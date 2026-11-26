<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Tryout;
use App\Models\Post;
use App\Models\ExamSession;
use App\Models\LearningCategory;
use App\Http\Controllers\UjianController;

class DashboardController extends Controller
{
    /**
     * Show the dashboard based on user role
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // If admin is accessing /dashboard, redirect to /admin/dashboard
        if ($user->isAdmin() && !request()->is('admin/*')) {
            return redirect()->route('admin.dashboard');
        }

        // Redirect regular user from /admin/dashboard (shouldn't happen due to middleware)
        if (!$user->isAdmin() && request()->is('admin/*')) {
            return redirect()->route('dashboard');
        }

        // Show admin dashboard for admins
        if ($user->isAdmin()) {
            $now = Carbon::now();
            $lastMonth = Carbon::now()->subMonth();

            // ── Statistik Kartu Utama ──
            $totalUsers = User::count();
            $totalQuestions = Question::count();

            $registrationsThisMonth = Transaction::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count();
            $paidRegistrationsThisMonth = Transaction::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->where('status', 'success')
                ->count();
            $revenueThisMonth = Transaction::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->where('status', 'success')
                ->sum('total_amount');

            // ── Perbandingan Bulan Lalu (untuk indikator ↑↓) ──
            $revenueLastMonth = Transaction::whereYear('created_at', $lastMonth->year)
                ->whereMonth('created_at', $lastMonth->month)
                ->where('status', 'success')
                ->sum('total_amount');
            $revenueChange = $revenueLastMonth > 0
                ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
                : ($revenueThisMonth > 0 ? 100 : 0);

            $newUsersThisMonth = User::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count();
            $newUsersLastMonth = User::whereYear('created_at', $lastMonth->year)
                ->whereMonth('created_at', $lastMonth->month)
                ->count();
            $userChange = $newUsersLastMonth > 0
                ? round((($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100, 1)
                : ($newUsersThisMonth > 0 ? 100 : 0);

            // ── Grafik Pendapatan Bulanan (6 bulan terakhir) ──
            $revenueChart = collect(range(5, 0))->map(function ($i) {
                $date = Carbon::now()->subMonths($i);
                $revenue = Transaction::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->where('status', 'success')
                    ->sum('total_amount');
                return [
                    'label' => $date->translatedFormat('M Y'),
                    'value' => (int) $revenue,
                ];
            })->values();

            // ── Grafik User Baru Harian (30 hari terakhir) ──
            $userChart = collect(range(29, 0))->map(function ($i) {
                $date = Carbon::today()->subDays($i);
                $count = User::whereDate('created_at', $date)->count();
                return [
                    'label' => $date->format('d M'),
                    'value' => $count,
                ];
            })->values();

            // ── 5 Transaksi Terbaru ──
            $latestTransactions = Transaction::with(['user:id,name,email', 'tryout:id,title'])
                ->latest()
                ->take(5)
                ->get();

            // ── 5 User Terbaru ──
            $latestUsers = User::where('role', '!=', 'admin')
                ->latest()
                ->take(5)
                ->get(['id', 'name', 'email', 'created_at']);

            // ── Info Operasional ──
            $pendingVerifications = Transaction::where('status', 'verifying')->count();
            $activeTryouts = Tryout::where('is_active', true)->count();
            $totalPosts = Post::whereNotNull('published_at')->count();
            $premiumUsers = User::where('is_premium', true)->count();
            $totalExamSessions = ExamSession::count();

            return view('admin.dashboard', compact(
                'totalUsers',
                'totalQuestions',
                'registrationsThisMonth',
                'paidRegistrationsThisMonth',
                'revenueThisMonth',
                'revenueChange',
                'newUsersThisMonth',
                'userChange',
                'revenueChart',
                'userChart',
                'latestTransactions',
                'latestUsers',
                'pendingVerifications',
                'activeTryouts',
                'totalPosts',
                'premiumUsers',
                'totalExamSessions'
            ));
        }

       // 1. Cek semua status paket secara independen (Case-insensitive)
        $hasPaket1 = Transaction::where('user_id', $user->id)->where('tryout_id', 1)->whereRaw('LOWER(status) = ?', ['success'])->exists();
        $hasPaket2 = Transaction::where('user_id', $user->id)->where('tryout_id', 2)->whereRaw('LOWER(status) = ?', ['success'])->exists();
        $hasPaket3 = Transaction::where('user_id', $user->id)->where('tryout_id', 3)->whereRaw('LOWER(status) = ?', ['success'])->exists();

        // 2. Tentukan status badge berdasarkan kombinasi
        // Lengkap jika: Beli Paket 2 (Langsung) OR (Beli Paket 1 AND Beli Paket 3) OR user memiliki status is_premium
        $isPaketLengkapPdf = $hasPaket2 || ($hasPaket1 && $hasPaket3) || ($user && $user->is_premium);
        
        // Mandiri jika: Beli Paket 1 AND BELUM punya Paket 3 AND BELUM punya Paket 2 AND bukan is_premium
        $isPaketTryoutSaja = $hasPaket1 && !$hasPaket3 && !$hasPaket2 && !($user && $user->is_premium);

        // B. Data Tryout
        $tryout = Tryout::find(1) ?? Tryout::first();

        // C. Cek Akses Ujian
        $access = ['status' => 'locked', 'message' => 'Silakan beli paket premium.'];
        if ($tryout) {
            $ujianController = app(UjianController::class);
            $access = $ujianController->checkUserAccess($tryout->id);
        }

        // D. Statistik & Progres Ujian User
        $userSessions = ExamSession::where('user_id', $user->id)
            ->whereNotNull('end_time')
            ->orderBy('created_at', 'asc')
            ->get();

        $totalUserExams = $userSessions->count();
        $hasCompletedExam = $totalUserExams > 0;

        $highestScore = 0;
        $passRatio = 0;
        $userRank = '-';
        $chartLabels = [];
        $chartScores = [];

        // Top 3 Peserta Nasional (Unik per User)
        $topNational = ExamSession::with('user:id,name')
            ->whereNotNull('end_time')
            ->orderByDesc('total_score')
            ->get()
            ->unique('user_id')
            ->take(3);

        $totalParticipants = ExamSession::whereNotNull('end_time')
            ->distinct('user_id')
            ->count('user_id');

        if ($hasCompletedExam) {
            $highestScore = $userSessions->max('total_score') ?? 0;

            // Passing grade SKD standar: TWK >= 65, TIU >= 80, TKP >= 166
            $passedCount = $userSessions->filter(function ($s) {
                return ($s->score_twk >= 65) && ($s->score_tiu >= 80) && ($s->score_tkp >= 166);
            })->count();

            $passRatio = round(($passedCount / $totalUserExams) * 100);

            // Hitung peringkat user secara nasional berdasarkan skor tertinggi user
            $usersWithHigherScore = ExamSession::whereNotNull('end_time')
                ->where('total_score', '>', $highestScore)
                ->distinct('user_id')
                ->count('user_id');

            $userRank = $usersWithHigherScore + 1;

            // Data grafik perkembangan skor
            foreach ($userSessions as $index => $session) {
                $dateStr = $session->created_at ? $session->created_at->format('d/m') : '';
                $chartLabels[] = 'TO ' . ($index + 1) . ($dateStr ? " ($dateStr)" : '');
                $chartScores[] = (int) $session->total_score;
            }
        } else {
            $chartLabels = ['TO 1', 'TO 2', 'TO 3', 'TO 4', 'TO 5'];
            $chartScores = [295, 325, 355, 390, 435];
        }

        $promo24h = $user->newMemberPromo();
        $tryoutMandiri = Tryout::find(1);
        $tryoutLengkap = Tryout::find(2);
        $tryoutUpgrade = Tryout::find(3);
        $learningCategories = LearningCategory::withCount('materials')->get();

        return view('user.dashboard', compact(
            'tryout',
            'access',
            'isPaketTryoutSaja',
            'isPaketLengkapPdf',
            'hasCompletedExam',
            'totalUserExams',
            'highestScore',
            'passRatio',
            'userRank',
            'totalParticipants',
            'chartLabels',
            'chartScores',
            'topNational',
            'promo24h',
            'tryoutMandiri',
            'tryoutLengkap',
            'tryoutUpgrade',
            'learningCategories'
        ));
    }
}
