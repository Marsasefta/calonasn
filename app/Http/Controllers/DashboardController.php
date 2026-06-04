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

        // ==========================================
        // LOGIKA DASHBOARD UNTUK USER BIASA
        // ==========================================
        
        // 1. Ambil data tryout premium (Contoh: mengambil Tryout ID 1, atau fallback ke tryout pertama)
        $tryout = Tryout::find(1) ?? Tryout::first();

        // 2. Siapkan variabel access default
        $access = ['status' => 'locked', 'message' => 'Silakan beli paket premium.'];

        // 3. Jika data tryout ditemukan, cek aksesnya menggunakan fungsi dari UjianController
        if ($tryout) {
            $ujianController = app(UjianController::class);
            $access = $ujianController->checkUserAccess($tryout->id);
        }

        // 4. Lempar variabel ke view dashboard user
        return view('user.dashboard', compact('tryout', 'access'));
    }
}
