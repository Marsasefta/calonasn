<?php

namespace App\Http\Controllers;

use App\Notifications\PaymentSuccessNotification;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'tryout'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transactions', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,success,failed,expired',
        ]);

        $transaction = Transaction::with('user')->findOrFail($id);
        $transaction->update(['status' => $request->status]);

        // Jika admin klik "Konfirmasi" (status success)
        if ($request->status === 'success' && $transaction->user) {
            
            // 1. Jadikan user premium
            $transaction->user->update(['is_premium' => true]);

            // 2. Kirim notifikasi email ke user tersebut
            $transaction->user->notify(new PaymentSuccessNotification($transaction));
        }

        return back()->with('success', 'Status transaksi berhasil diperbarui dan email notifikasi telah dikirim ke user.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
