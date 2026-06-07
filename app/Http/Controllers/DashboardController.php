<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Tryout;
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
            $totalUsers = User::count();
            $totalQuestions = Question::count();
            $revenueThisMonth = Transaction::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->where('status', 'success')
                ->sum('amount');
            $onlineUsers = DB::table('sessions')
                ->where('last_activity', '>=', Carbon::now()->subMinutes(15)->getTimestamp())
                ->count();

            return view('admin.dashboard', compact('totalUsers', 'totalQuestions', 'revenueThisMonth', 'onlineUsers'));
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
