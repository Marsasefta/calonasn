<?php

namespace App\Http\Controllers;

use App\Notifications\AdminPaymentNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Menampilkan halaman detail paket dan tombol beli
    public function checkout()
    {
        // Ganti dengan mengambil data dari tabel Tryout jika sudah ada
        $tryout = (object) [
            'id' => 1,
            'title' => 'Paket Tryout CPNS Premium',
            'price' => 20000
        ];

        return view('user.payment.checkout', compact('tryout'));
    }

    // Memproses klik "Beli" dan buat tagihan PENDING
    public function process(Request $request)
    {
        $userId = Auth::id();
        $tryoutId = $request->tryout_id;
        
        // Ambil harga (Jika tabel tryouts sudah jalan, gunakan Tryout::find)
        $amount = $request->amount ?? 50000; 

        // 1. Cek apakah ada tagihan pending agar tidak double
        $pendingTx = Transaction::where('user_id', $userId)
                        ->where('tryout_id', $tryoutId)
                        ->whereIn('status', ['pending', 'verifying'])
                        ->first();

        if ($pendingTx) {
            // FIX BUG: Jika data lama belum punya invoice_number, buatkan instan
            if (empty($pendingTx->invoice_number)) {
                $pendingTx->update([
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5)),
                    'unique_code'    => rand(111, 999),
                    'total_amount'   => ($pendingTx->amount ?? $amount) + rand(111, 999),
                    'payment_method' => 'qris',
                ]);
                $pendingTx->refresh();
            }

            return redirect()->route('payment.qris', $pendingTx->invoice_number)
                ->with('info', 'Selesaikan pembayaran Anda sebelumnya.');
        }

        // 2. Generate Data Unik
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
        $uniqueCode = rand(1, 199); // 3 digit unik
        $totalAmount = $amount + $uniqueCode;
        $expiredAt = now()->addHours(24); // Waktu kedaluwarsa 24 jam

        // 3. Simpan ke database
        $transaction = Transaction::create([
            'user_id'        => $userId,
            'tryout_id'      => $tryoutId,
            'order_id'       => $invoiceNumber,
            'invoice_number' => $invoiceNumber,
            'amount'         => $amount,
            'unique_code'    => $uniqueCode,
            'total_amount'   => $totalAmount,
            'payment_method' => 'qris',
            'status'         => 'pending',
            'expired_at'     => $expiredAt,
        ]);

        return redirect()->route('payment.qris', $transaction->invoice_number);
    }

    // Menampilkan Halaman QRIS & Form Upload
    public function qris($invoice_number)
    {
        $transaction = Transaction::where('invoice_number', $invoice_number)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if ($transaction->status == 'paid' || $transaction->status == 'success' || $transaction->status == 'failed') {
            return redirect()->route('riwayat')->with('error', 'Tagihan tidak valid atau sudah selesai.');
        }

        return view('user.payment.qris', compact('transaction'));
    }

    // Memproses Upload Bukti Pembayaran
    public function uploadProof(Request $request, $invoice_number)
    {
        $request->validate([
                'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:15360', // 15MB
            ], [
                'payment_proof.max' => 'Ukuran file bukti transfer terlalu besar, maksimal adalah 15MB.',
                'payment_proof.image' => 'File harus berupa gambar.',
                'payment_proof.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
        ]);

        $transaction = Transaction::where('invoice_number', $invoice_number)
                        ->where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->firstOrFail();

        $path = $request->file('payment_proof')->store('bukti_transfer', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'status'        => 'pending' 
        ]);

        // --- SINKRONISASI NOTIFIKASI EMAIL ADMIN ---
        // Masukkan email kamu dan temanmu di dalam array ini
        $adminEmails = ['fenthalari@gmail.com','Marsasefta02@gmail.com'];

        // Kirim notifikasi menggunakan facade Notification Laravel
        Notification::route('mail', $adminEmails)->notify(new AdminPaymentNotification($transaction));
        // --- END NOTIFIKASI ---

        return redirect()->route('payment.pending')->with('success', 'Bukti transfer berhasil diunggah.');
    }

    public function success()
    {
        $transaction = Transaction::where('user_id', Auth::id())
                        ->whereIn('status', ['success', 'paid'])
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
        $userId = Auth::id();

        // 1. Ambil data transaksi (Riwayat Pembayaran)
        $transactions = Transaction::where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // 2. Ambil data sesi ujian (Riwayat Nilai & Sertifikat)
        $riwayatUjian = \App\Models\ExamSession::with('tryout')
                            ->where('user_id', $userId)
                            ->whereNotNull('end_time') 
                            ->orderBy('end_time', 'desc')
                            ->get();

        return view('user.riwayat_transaksi.riwayat', compact('transactions', 'riwayatUjian'));
    }

    public function invoice($invoice_number)
    {
        // Cari menggunakan klon ganda agar order_id lama maupun invoice_number baru tetap bisa mencetak invoice
        $transaction = Transaction::where('user_id', Auth::id())
                        ->where(function($query) use ($invoice_number) {
                            $query->where('invoice_number', $invoice_number)
                                  ->orWhere('order_id', $invoice_number);
                        })
                        ->firstOrFail();

        return view('user.riwayat_transaksi.invoice', compact('transaction'));
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $transaction->delete();

        return redirect()->route('riwayat')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
