<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

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
                ->where('status', 'settlement')
                ->sum('amount');
            $onlineUsers = DB::table('sessions')
                ->where('last_activity', '>=', Carbon::now()->subMinutes(15)->getTimestamp())
                ->count();

            return view('admin.dashboard', compact('totalUsers', 'totalQuestions', 'revenueThisMonth', 'onlineUsers'));
        }

        // Show user dashboard for regular users
        return view('user.dashboard');
    }
}
