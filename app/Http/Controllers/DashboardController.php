<?php

namespace App\Http\Controllers;

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
            return view('admin.dashboard');
        }

        // Show user dashboard for regular users
        return view('user.dashboard');
    }
}
