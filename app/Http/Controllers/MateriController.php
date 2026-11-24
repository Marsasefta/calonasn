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
    // Method untuk halaman Lobby (Menampilkan 3 Kategori)
    public function index()
    {
        $user = auth()->user();
        $userId = $user ? $user->id : null;
        $categories = LearningCategory::withCount('materials')->get();

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
            $hasFullAccess = $hasPaketLengkap || $hasPaketUpgrade || ($user && $user->is_premium);
        }

        $completedMaterialIds = $userId 
            ? UserMaterialProgress::where('user_id', $userId)->pluck('learning_material_id')->toArray()
            : [];

        foreach ($categories as $category) {
            $catMaterialIds = $category->materials->pluck('id')->toArray();
            $totalInCat = count($catMaterialIds);
            $completedInCat = count(array_intersect($catMaterialIds, $completedMaterialIds));
            
            $category->completed_count = $completedInCat;
            $category->progress_percent = $totalInCat > 0 ? round(($completedInCat / $totalInCat) * 100) : 0;
        }

        return view('user.materi.index', compact('categories', 'hasFullAccess', 'sudahBeliPaket1'));
    }

    // Method untuk halaman Micro-Learning (Saat salah satu kategori diklik)
    public function show($categorySlug, $materialSlug = null)
    {
        $category = LearningCategory::where('slug', $categorySlug)->firstOrFail();
        $chapters = $category->chapters()->with('materials')->orderBy('order_number')->get();

        // 1. CEK HAK AKSES USER (Apakah punya Paket 2 / Paket 3 / is_premium)
        $user = auth()->user();
        $hasFullAccess = false;
        $sudahBeliPaket1 = false;

        if ($user) {
            // 1. Cek Paket 2 (Beli Langsung 49rb)
            $hasPaketLengkap = Transaction::where('user_id', $user->id)
                                            ->where('tryout_id', 2)
                                            ->whereRaw('LOWER(status) = ?', ['success'])
                                            ->exists();

            // 2. Cek Paket 1 + Paket 3 (Beli Bertahap 20rb + 29rb)
            $sudahBeliPaket1 = Transaction::where('user_id', $user->id)
                                        ->where('tryout_id', 1)
                                        ->whereRaw('LOWER(status) = ?', ['success'])
                                        ->exists();
                                        
            $hasPaket3 = Transaction::where('user_id', $user->id)
                                        ->where('tryout_id', 3)
                                        ->whereRaw('LOWER(status) = ?', ['success'])
                                        ->exists();

            $hasPaketUpgrade = $sudahBeliPaket1 && $hasPaket3;

            // Gabungkan: Beli Paket Lengkap / Hasil Upgrade / Akun is_premium
            $hasFullAccess = $hasPaketLengkap || $hasPaketUpgrade || ($user && $user->is_premium);
        }

        // Tentukan rute & label upgrade dinamis
        $upgradeRoute = $sudahBeliPaket1 ? route('checkout', 3) : route('checkout', 2);
        $upgradeLabel = $sudahBeliPaket1 ? 'Upgrade ke Paket Lengkap (Rp 29.000)' : 'Beli Paket Lengkap (Rp 49.000)';
        $upgradePrice = $sudahBeliPaket1 ? 'Rp 29.000' : 'Rp 49.000';

        // 2. TENTUKAN MATERI AKTIF
        if ($materialSlug) {
            $currentMaterial = LearningMaterial::where('slug', $materialSlug)->firstOrFail();
        } else {
            $currentMaterial = $category->chapters->first()->materials->first();
        }

        // 3. KEAMANAN BACKEND (Mencegah user nakal ketik URL manual)
        // Jika materi ini dilock (is_locked == 1) DAN user tidak punya Full Access
        if ($currentMaterial->is_locked == 1 && !$hasFullAccess) {
            $msg = $sudahBeliPaket1 
                ? 'Materi ini eksklusif untuk member Paket Lengkap. Upgrade sekarang seharga Rp 29.000 untuk membuka semua bab.' 
                : 'Materi ini eksklusif untuk member Paket Lengkap. Silakan aktifkan paket untuk membuka semua materi.';
            return redirect($upgradeRoute)->with('error', $msg);
        }

        // 4. LOGIKA PINTAR: Cari materi berikutnya
        // A. Coba cari materi selanjutnya di bab yang sama
        $nextMaterial = LearningMaterial::where('learning_chapter_id', $currentMaterial->learning_chapter_id)
            ->where('order_number', '>', $currentMaterial->order_number)
            ->orderBy('order_number', 'asc')
            ->first();

        // B. Jika di bab yang sama tidak ada, cari bab selanjutnya
        if (!$nextMaterial) {
            $currentChapter = LearningChapter::find($currentMaterial->learning_chapter_id);
            
            $nextChapter = LearningChapter::where('learning_category_id', $category->id)
                ->where('order_number', '>', $currentChapter->order_number)
                ->orderBy('order_number', 'asc')
                ->first();

            if ($nextChapter) {
                $nextMaterial = $nextChapter->materials()->orderBy('order_number', 'asc')->first();
            }
        }

        $tryout = Tryout::find(1) ?? Tryout::first();

        // Riwayat materi yang sudah diselesaikan user dalam kategori ini
        $completedMaterialIds = $user 
            ? UserMaterialProgress::where('user_id', $user->id)->pluck('learning_material_id')->toArray()
            : [];

        $isCurrentCompleted = in_array($currentMaterial->id, $completedMaterialIds);

        $categoryMaterialIds = $category->materials->pluck('id')->toArray();
        $totalCategoryMaterials = count($categoryMaterialIds);
        $completedCategoryCount = count(array_intersect($categoryMaterialIds, $completedMaterialIds));
        $progressPercent = $totalCategoryMaterials > 0 ? round(($completedCategoryCount / $totalCategoryMaterials) * 100) : 0;

        // 5. Lempar variabel ke View Blade
        return view('user.materi.show', compact(
            'category',
            'chapters',
            'currentMaterial',
            'nextMaterial',
            'hasFullAccess',
            'sudahBeliPaket1',
            'upgradeRoute',
            'upgradeLabel',
            'upgradePrice',
            'tryout',
            'completedMaterialIds',
            'isCurrentCompleted',
            'completedCategoryCount',
            'totalCategoryMaterials',
            'progressPercent'
        ));
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
