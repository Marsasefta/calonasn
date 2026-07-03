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

       // 1. Cek semua status paket secara independen
        $hasPaket1 = Transaction::where('user_id', $user->id)->where('tryout_id', 1)->where('status', 'Success')->exists();
        $hasPaket2 = Transaction::where('user_id', $user->id)->where('tryout_id', 2)->where('status', 'Success')->exists();
        $hasPaket3 = Transaction::where('user_id', $user->id)->where('tryout_id', 3)->where('status', 'Success')->exists();

        // 2. Tentukan status badge berdasarkan kombinasi
        // Lengkap jika: Beli Paket 2 (Langsung) OR (Beli Paket 1 AND Beli Paket 3)
        $isPaketLengkapPdf = $hasPaket2 || ($hasPaket1 && $hasPaket3);
        
        // Mandiri jika: Beli Paket 1 AND BELUM punya Paket 3 AND BELUM punya Paket 2
        $isPaketTryoutSaja = $hasPaket1 && !$hasPaket3 && !$hasPaket2;

        // B. Data Tryout
        $tryout = Tryout::find(1) ?? Tryout::first();

        // C. Cek Akses Ujian
        $access = ['status' => 'locked', 'message' => 'Silakan beli paket premium.'];
        if ($tryout) {
            $ujianController = app(UjianController::class);
            $access = $ujianController->checkUserAccess($tryout->id);
        }

        return view('user.dashboard', compact('tryout', 'access', 'isPaketTryoutSaja', 'isPaketLengkapPdf'));
    }
}
