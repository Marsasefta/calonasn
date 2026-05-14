<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Menampilkan halaman detail paket dan tombol beli
    public function checkout()
    {
        // DUMMY DATA TRYOUT (Karena tabel tryouts mungkin belum ada)
        $tryout = (object) [
            'id' => 1,
            'title' => 'Paket Tryout CPNS Batch 1',
            'price' => 20000
        ];

        return view('user.payment.checkout', compact('tryout'));
    }

    // Memproses klik "Beli" dan simpan ke database
    public function process(Request $request)
    {
        // Generate Order ID
        $orderId = 'TR-CPNS-' . time();

        // Simpan ke database
        Transaction::create([
            'user_id' => Auth::id(),
            'tryout_id' => $request->tryout_id,
            'order_id' => $orderId,
            'amount' => $request->amount,
            
            // PAKSA STATUS JADI SUCCESS KHUSUS UNTUK DEMO
            'status' => 'success', 
        ]);

        // Langsung lempar ke halaman sukses
        return redirect()->route('payment.success');
    }

    public function success()
    {
        // Ambil data transaksi terakhir milik peserta yang sukses
        $transaction = Transaction::where('user_id', Auth::id())
                        ->where('status', 'success')
                        ->latest()
                        ->first();

        return view('user.payment.payment-success', compact('transaction'));
    }

    public function pending()
    {
        return view('user.payment.payment-pending');
    }
}
