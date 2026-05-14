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

    public function history()
    {
        // Mengambil semua transaksi milik user yang login, diurutkan dari yang terbaru
        $transactions = Transaction::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('user.riwayat.riwayat', compact('transactions'));
    }

    public function invoice($order_id)
    {
        // Cari transaksi berdasarkan order_id dan pastikan itu milik user yang sedang login
        $transaction = Transaction::where('order_id', $order_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        return view('user.riwayat.invoice', compact('transaction'));
    }

    public function destroy($id)
    {
        // Cari transaksi berdasarkan ID dan pastikan milik user yang login
        $transaction = Transaction::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        // Hapus data
        $transaction->delete();

        // Balikkan ke halaman riwayat dengan pesan sukses
        return redirect()->route('riwayat')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
