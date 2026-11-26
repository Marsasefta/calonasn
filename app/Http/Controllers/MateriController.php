<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LearningCategory;
use App\Models\LearningMaterial;
use App\Models\LearningChapter;
use App\Models\Transaction;
use App\Models\Tryout;
use App\Models\UserMaterialProgress;

class MateriController extends Controller
{
    /**
     * Hitung status akses materi dan info harga upgrade dinamis.
     */
    private function resolveAccessState($user): array
    {
        $hasFullAccess = false;
        $sudahBeliPaket1 = false;

        if ($user) {
            $hasPaketLengkap = Transaction::where('user_id', $user->id)
                ->where('tryout_id', 2)
                ->whereRaw('LOWER(status) = ?', ['success'])
                ->exists();

            $sudahBeliPaket1 = Transaction::where('user_id', $user->id)
                ->where('tryout_id', 1)
                ->whereRaw('LOWER(status) = ?', ['success'])
                ->exists();

            $hasPaket3 = Transaction::where('user_id', $user->id)
                ->where('tryout_id', 3)
                ->whereRaw('LOWER(status) = ?', ['success'])
                ->exists();

            $hasPaketUpgrade = $sudahBeliPaket1 && $hasPaket3;
            $hasFullAccess = $hasPaketLengkap || $hasPaketUpgrade || (bool) $user->is_premium;
        }

        $promo24h = $user?->newMemberPromo();
        $hargaLengkap = (int) (Tryout::find(2)->price ?? 49000);
        $hargaUpgrade = (int) (Tryout::find(3)->price ?? 29000);

        if ($sudahBeliPaket1) {
            $upgradeRoute = route('checkout', 3);
            $upgradePriceNum = $hargaUpgrade;
            $upgradeNormalPriceNum = $hargaLengkap;
            $upgradeLabel = 'Upgrade ke Paket Lengkap (Rp ' . number_format($upgradePriceNum, 0, ',', '.') . ')';
        } else {
            $upgradeRoute = route('checkout', 2);
            $diskon = $promo24h ? (int) $promo24h['discount_amount'] : 0;
            $upgradeNormalPriceNum = $hargaLengkap;
            $upgradePriceNum = max(0, $hargaLengkap - $diskon);
            $upgradeLabel = 'Buka Semua Materi (Rp ' . number_format($upgradePriceNum, 0, ',', '.') . ')';
        }

        return [
            'hasFullAccess'         => $hasFullAccess,
            'sudahBeliPaket1'       => $sudahBeliPaket1,
            'promo24h'              => $promo24h,
            'upgradeRoute'          => $upgradeRoute,
            'upgradeLabel'          => $upgradeLabel,
            'upgradePrice'          => 'Rp ' . number_format($upgradePriceNum, 0, ',', '.'),
            'upgradePriceNum'       => $upgradePriceNum,
            'upgradeNormalPriceNum' => $upgradeNormalPriceNum,
        ];
    }

    // Method untuk halaman Lobby (Menampilkan 3 Kategori)
    public function index()
    {
        $user = auth()->user();
        $userId = $user ? $user->id : null;
        $categories = LearningCategory::with('materials')->withCount('materials')->get();
        $accessState = $this->resolveAccessState($user);

        $completedMaterialIds = $userId
            ? UserMaterialProgress::where('user_id', $userId)->pluck('learning_material_id')->toArray()
            : [];

        $totalMaterialsCount = 0;
        $totalLockedCount = 0;

        foreach ($categories as $category) {
            $catMaterials = $category->materials;
            $catMaterialIds = $catMaterials->pluck('id')->toArray();
            $totalInCat = count($catMaterialIds);
            $completedInCat = count(array_intersect($catMaterialIds, $completedMaterialIds));
            $lockedInCat = $catMaterials->where('is_locked', 1)->count();

            $category->completed_count = $completedInCat;
            $category->progress_percent = $totalInCat > 0 ? round(($completedInCat / $totalInCat) * 100) : 0;
            $category->locked_count = $lockedInCat;
            $category->free_count = max(0, $totalInCat - $lockedInCat);

            $totalMaterialsCount += $totalInCat;
            $totalLockedCount += $lockedInCat;
        }

        return view('user.materi.index', array_merge($accessState, compact(
            'categories',
            'totalMaterialsCount',
            'totalLockedCount'
        )));
    }

    // Method untuk halaman Micro-Learning (Saat salah satu kategori diklik)
    public function show($categorySlug, $materialSlug = null)
    {
        $category = LearningCategory::where('slug', $categorySlug)->firstOrFail();
        $chapters = $category->chapters()
            ->with(['materials' => fn ($q) => $q->orderBy('order_number', 'asc')])
            ->orderBy('order_number', 'asc')
            ->get();

        $user = auth()->user();
        $accessState = $this->resolveAccessState($user);
        $hasFullAccess = $accessState['hasFullAccess'];
        $sudahBeliPaket1 = $accessState['sudahBeliPaket1'];
        $upgradeRoute = $accessState['upgradeRoute'];

        $orderedMaterials = $chapters->pluck('materials')->flatten();

        // 2. TENTUKAN MATERI AKTIF (gunakan urutan chapter & fallback aman)
        if ($materialSlug) {
            $currentMaterial = $orderedMaterials->firstWhere('slug', $materialSlug)
                ?? LearningMaterial::where('slug', $materialSlug)->firstOrFail();
        } else {
            $currentMaterial = $hasFullAccess
                ? $orderedMaterials->first()
                : ($orderedMaterials->firstWhere('is_locked', 0) ?? $orderedMaterials->first());

            if (!$currentMaterial) {
                abort(404, 'Materi pada kategori ini belum tersedia.');
            }
        }

        // 3. KEAMANAN BACKEND (Mencegah user nakal ketik URL manual)
        if ($currentMaterial->is_locked == 1 && !$hasFullAccess) {
            $msg = $sudahBeliPaket1
                ? 'Materi ini eksklusif untuk member Paket Lengkap. Upgrade sekarang seharga ' . $accessState['upgradePrice'] . ' untuk membuka semua bab.'
                : 'Materi ini eksklusif untuk member Paket Lengkap. Silakan aktifkan paket untuk membuka semua materi.';
            return redirect($upgradeRoute)->with('error', $msg);
        }

        // 4. LOGIKA PINTAR: Cari materi berikutnya berdasarkan urutan bab & materi
        $currentIndex = $orderedMaterials->search(fn ($m) => $m->id === $currentMaterial->id);
        $nextMaterial = ($currentIndex !== false && isset($orderedMaterials[$currentIndex + 1]))
            ? $orderedMaterials[$currentIndex + 1]
            : null;

        $tryout = Tryout::find(1) ?? Tryout::first();

        $completedMaterialIds = $user
            ? UserMaterialProgress::where('user_id', $user->id)->pluck('learning_material_id')->toArray()
            : [];

        $isCurrentCompleted = in_array($currentMaterial->id, $completedMaterialIds);

        $categoryMaterialIds = $orderedMaterials->pluck('id')->toArray();
        $totalCategoryMaterials = count($categoryMaterialIds);
        $completedCategoryCount = count(array_intersect($categoryMaterialIds, $completedMaterialIds));
        $progressPercent = $totalCategoryMaterials > 0 ? round(($completedCategoryCount / $totalCategoryMaterials) * 100) : 0;

        // 5. Lempar variabel ke View Blade
        return view('user.materi.show', array_merge($accessState, compact(
            'category',
            'chapters',
            'currentMaterial',
            'nextMaterial',
            'tryout',
            'completedMaterialIds',
            'isCurrentCompleted',
            'completedCategoryCount',
            'totalCategoryMaterials',
            'progressPercent'
        )));
    }

    public function toggleProgress($id)
    {
        $userId = auth()->id();
        $material = LearningMaterial::with('chapter.category')->findOrFail($id);

        $progress = UserMaterialProgress::where('user_id', $userId)
            ->where('learning_material_id', $material->id)
            ->first();

        if ($progress) {
            $progress->delete();
            $isCompleted = false;
        } else {
            UserMaterialProgress::create([
                'user_id' => $userId,
                'learning_material_id' => $material->id,
                'completed_at' => now(),
            ]);
            $isCompleted = true;
        }

        $category = $material->chapter->category ?? null;
        $categoryMaterialIds = $category ? $category->materials->pluck('id')->toArray() : [];
        $totalCategoryMaterials = count($categoryMaterialIds);
        $completedCategoryCount = UserMaterialProgress::where('user_id', $userId)
            ->whereIn('learning_material_id', $categoryMaterialIds)
            ->count();

        $percent = $totalCategoryMaterials > 0 ? round(($completedCategoryCount / $totalCategoryMaterials) * 100) : 0;

        return response()->json([
            'status' => 'success',
            'is_completed' => $isCompleted,
            'completed_count' => $completedCategoryCount,
            'total_count' => $totalCategoryMaterials,
            'percentage' => $percent,
            'material_id' => $material->id
        ]);
    }
}
