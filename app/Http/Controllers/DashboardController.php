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
            // Data dummy leaderboard skor peserta
            $leaderboard = [
                ['rank' => 1, 'name' => 'Ahmad Ridho', 'score' => 950, 'attempts' => 5, 'date' => '2026-05-14'],
                ['rank' => 2, 'name' => 'Siti Nurhaliza', 'score' => 920, 'attempts' => 4, 'date' => '2026-05-13'],
                ['rank' => 3, 'name' => 'Budi Santoso', 'score' => 895, 'attempts' => 6, 'date' => '2026-05-12'],
                ['rank' => 4, 'name' => 'Dewi Lestari', 'score' => 875, 'attempts' => 3, 'date' => '2026-05-11'],
                ['rank' => 5, 'name' => 'Eka Prasetya', 'score' => 850, 'attempts' => 7, 'date' => '2026-05-10'],
                ['rank' => 6, 'name' => 'Farah Azzahra', 'score' => 820, 'attempts' => 4, 'date' => '2026-05-09'],
                ['rank' => 7, 'name' => 'Gilang Maulana', 'score' => 795, 'attempts' => 5, 'date' => '2026-05-08'],
                ['rank' => 8, 'name' => 'Hana Kusuma', 'score' => 770, 'attempts' => 3, 'date' => '2026-05-07'],
                ['rank' => 9, 'name' => 'Irfan Wijaya', 'score' => 745, 'attempts' => 6, 'date' => '2026-05-06'],
                ['rank' => 10, 'name' => 'Jaya Putri', 'score' => 720, 'attempts' => 4, 'date' => '2026-05-05'],
            ];

            // Data dummy transaksi finansial (Midtrans)
            $transactions = [
                ['id' => 'TXN001', 'customer' => 'Ahmad Ridho', 'amount' => 99000, 'status' => 'settlement', 'method' => 'Bank Transfer', 'date' => '2026-05-14 10:30', 'email' => 'ahmad@email.com'],
                ['id' => 'TXN002', 'customer' => 'Siti Nurhaliza', 'amount' => 149000, 'status' => 'settlement', 'method' => 'Credit Card', 'date' => '2026-05-14 11:15', 'email' => 'siti@email.com'],
                ['id' => 'TXN003', 'customer' => 'Budi Santoso', 'amount' => 99000, 'status' => 'pending', 'method' => 'E-Wallet', 'date' => '2026-05-14 12:00', 'email' => 'budi@email.com'],
                ['id' => 'TXN004', 'customer' => 'Dewi Lestari', 'amount' => 249000, 'status' => 'settlement', 'method' => 'Bank Transfer', 'date' => '2026-05-13 14:45', 'email' => 'dewi@email.com'],
                ['id' => 'TXN005', 'customer' => 'Eka Prasetya', 'amount' => 149000, 'status' => 'expired', 'method' => 'Credit Card', 'date' => '2026-05-13 15:20', 'email' => 'eka@email.com'],
                ['id' => 'TXN006', 'customer' => 'Farah Azzahra', 'amount' => 99000, 'status' => 'settlement', 'method' => 'E-Wallet', 'date' => '2026-05-12 16:00', 'email' => 'farah@email.com'],
                ['id' => 'TXN007', 'customer' => 'Gilang Maulana', 'amount' => 249000, 'status' => 'pending', 'method' => 'Bank Transfer', 'date' => '2026-05-12 17:30', 'email' => 'gilang@email.com'],
                ['id' => 'TXN008', 'customer' => 'Hana Kusuma', 'amount' => 149000, 'status' => 'settlement', 'method' => 'E-Wallet', 'date' => '2026-05-11 09:15', 'email' => 'hana@email.com'],
            ];

            // Hitung statistik finansial
            $totalRevenue = collect($transactions)->where('status', 'settlement')->sum('amount');
            $pendingRevenue = collect($transactions)->where('status', 'pending')->sum('amount');
            $successfulTransactions = collect($transactions)->where('status', 'settlement')->count();
            $totalTransactions = collect($transactions)->count();

            return view('admin.dashboard', compact('leaderboard', 'transactions', 'totalRevenue', 'pendingRevenue', 'successfulTransactions', 'totalTransactions'));
        }

        // Show user dashboard for regular users
        return view('user.dashboard');
    }
}
