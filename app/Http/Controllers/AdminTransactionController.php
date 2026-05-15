<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'tryout'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.transactions', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,settlement,failed,expired',
        ]);

        $transaction = Transaction::with('user')->findOrFail($id);
        $transaction->update(['status' => $request->status]);

        if ($request->status === 'settlement' && $transaction->user) {
            $transaction->user->update(['is_premium' => true]);
        }

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
