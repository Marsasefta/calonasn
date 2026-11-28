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
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
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
            $revenueThisMonth = (int) Transaction::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->where('status', 'success')
                ->sum('total_amount');

            // ── Pendapatan Harian (Hari Ini vs Kemarin) & Total Keseluruhan ──
            $todayStats = Transaction::where('status', 'success')
                ->whereDate('created_at', $today)
                ->selectRaw('COUNT(*) as tx_count, COALESCE(SUM(total_amount), 0) as total')
                ->first();
            $revenueToday = (int) ($todayStats->total ?? 0);
            $paidToday = (int) ($todayStats->tx_count ?? 0);

            $revenueYesterday = (int) Transaction::where('status', 'success')
                ->whereDate('created_at', $yesterday)
                ->sum('total_amount');
            $dailyRevenueChange = $revenueYesterday > 0
                ? round((($revenueToday - $revenueYesterday) / $revenueYesterday) * 100, 1)
                : ($revenueToday > 0 ? 100 : 0);

            $allTimeStats = Transaction::where('status', 'success')
                ->selectRaw('COUNT(*) as tx_count, COALESCE(SUM(total_amount), 0) as total')
                ->first();
            $totalRevenueAllTime = (int) ($allTimeStats->total ?? 0);
            $totalPaidTransactions = (int) ($allTimeStats->tx_count ?? 0);

            // ── Perbandingan Bulan Lalu (untuk indikator ↑↓) ──
            $revenueLastMonth = (int) Transaction::whereYear('created_at', $lastMonth->year)
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

            // ── Grafik & Rekap Pendapatan Harian (30 hari terakhir) ──
            $dailyStart = $today->copy()->subDays(29)->startOfDay();
            $dailyRows = Transaction::where('status', 'success')
                ->where('created_at', '>=', $dailyStart)
                ->selectRaw('DATE(created_at) as trx_date, COUNT(*) as tx_count, COALESCE(SUM(total_amount), 0) as total')
                ->groupBy('trx_date')
                ->get()
                ->keyBy('trx_date');

            $dailyRevenueChart = collect(range(29, 0))->map(function ($i) use ($today, $dailyRows) {
                $date = $today->copy()->subDays($i);
                $key = $date->format('Y-m-d');
                $row = $dailyRows->get($key);
                return [
                    'date' => $key,
                    'label' => $date->format('d M'),
                    'full_date' => $date->translatedFormat('d M Y'),
                    'is_today' => $i === 0,
                    'value' => (int) ($row->total ?? 0),
                    'count' => (int) ($row->tx_count ?? 0),
                ];
            })->values();

            $dailyRevenueTable = $dailyRevenueChart
                ->filter(fn ($item) => $item['is_today'] || $item['count'] > 0)
                ->reverse()
                ->values();

            // ── Grafik & Rekap Pendapatan Bulanan (12 bulan terakhir) ──
            $monthlyStart = $now->copy()->startOfMonth()->subMonths(11);
            $monthlyRows = Transaction::where('status', 'success')
                ->where('created_at', '>=', $monthlyStart)
                ->selectRaw('YEAR(created_at) as yr, MONTH(created_at) as mo, COUNT(*) as tx_count, COALESCE(SUM(total_amount), 0) as total')
                ->groupBy('yr', 'mo')
                ->get()
                ->keyBy(fn ($r) => sprintf('%04d-%02d', $r->yr, $r->mo));

            $monthlyRevenueChart = collect(range(11, 0))->map(function ($i) use ($now, $monthlyRows) {
                $date = $now->copy()->startOfMonth()->subMonths($i);
                $key = $date->format('Y-m');
                $row = $monthlyRows->get($key);
                return [
                    'key' => $key,
                    'label' => $date->translatedFormat('M Y'),
                    'full_label' => $date->translatedFormat('F Y'),
                    'is_current' => $i === 0,
                    'value' => (int) ($row->total ?? 0),
                    'count' => (int) ($row->tx_count ?? 0),
                ];
            })->values();

            $monthlyRevenueTable = $monthlyRevenueChart->map(function ($item, $idx) use ($monthlyRevenueChart) {
                $prev = $idx > 0 ? $monthlyRevenueChart[$idx - 1]['value'] : 0;
                $growth = $prev > 0
                    ? round((($item['value'] - $prev) / $prev) * 100, 1)
                    : ($item['value'] > 0 && $idx > 0 ? 100 : null);
                $item['growth'] = $growth;
                return $item;
            })->reverse()->values();

            // Pertahankan 6 bulan terakhir pada $revenueChart untuk kompatibilitas
            $revenueChart = $monthlyRevenueChart->slice(6)->values();

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

            // ── Peserta Sedang Ujian (auto-close sesi kadaluarsa > 100 menit) ──
            app(UjianController::class)->closeExpiredUnfinishedSessions();
            $activeExamSessions = ExamSession::with(['user:id,name,email', 'tryout:id,title'])
                ->whereNull('end_time')
                ->orderBy('start_time', 'desc')
                ->get();

            return view('admin.dashboard', compact(
                'totalUsers',
                'totalQuestions',
                'registrationsThisMonth',
                'paidRegistrationsThisMonth',
                'revenueThisMonth',
                'revenueChange',
                'revenueToday',
                'paidToday',
                'revenueYesterday',
                'dailyRevenueChange',
                'totalRevenueAllTime',
                'totalPaidTransactions',
                'newUsersThisMonth',
                'userChange',
                'revenueChart',
                'dailyRevenueChart',
                'dailyRevenueTable',
                'monthlyRevenueChart',
                'monthlyRevenueTable',
                'userChart',
                'latestTransactions',
                'latestUsers',
                'pendingVerifications',
                'activeTryouts',
                'totalPosts',
                'premiumUsers',
                'totalExamSessions',
                'activeExamSessions'
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
