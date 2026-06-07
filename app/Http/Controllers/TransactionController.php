<?php

namespace App\Http\Controllers;

use App\Models\PromoCode; // Pastikan model PromoCode di-import di paling atas
use App\Notifications\AdminPaymentNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Transaction;
use App\Models\Tryout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    public function checkout(Request $request, $id = null)
    {
        // 1. Prioritas Utama: Jika ada ID (Contoh: /checkout/3)
        if ($id) {
            // findOrFail akan otomatis menampilkan halaman 404 
            // jika user sengaja mengubah URL ke ID yang tidak ada di database
            $tryout = Tryout::findOrFail($id);
        } 
        // 2. Jika tidak ada ID, cek query string (Contoh: /checkout?package=tryout-pdf)
        elseif ($request->has('package')) {
            $package = $request->query('package');

            if ($package === 'tryout-pdf') {
                $tryout = Tryout::findOrFail(2);
            } elseif ($package === 'upgrade') { // Opsional: jika kamu mau akses ID 3 via ?package=upgrade
                $tryout = Tryout::findOrFail(3);
            } else {
                $tryout = Tryout::findOrFail(1);
            }
        } 
        // 3. Jika nyasar tanpa parameter
        else {
            $tryout = Tryout::findOrFail(1); 
        }

        // Jika tryout ditemukan, lempar ke view
        return view('user.payment.checkout', compact('tryout'));
    }

    // Memproses klik "Beli" dan buat tagihan PENDING
    public function process(Request $request)
    {
        $userId = Auth::id();
        $tryoutId = $request->tryout_id;
        
        // Ambil harga asli paket
        $amount = $request->amount ?? 50000; 

        // --- 1. AMBIL LOGIKA PROMO CODE TERLEBIH DAHULU ---
        $discountAmount = 0;
        $promoCodeId = null;

        if ($request->filled('promo_code_id')) {
            $promo = \App\Models\PromoCode::where('id', $request->promo_code_id)
                                          ->where('status', 'aktif')
                                          ->first();
                                          
            if ($promo) {
                $discountAmount = $promo->discount_amount;
                $promoCodeId = $promo->id;
            }
        }

        // --- 2. CEK APAKAH ADA TAGIHAN PENDING ---
        $pendingTx = Transaction::where('user_id', $userId)
                        ->where('tryout_id', $tryoutId)
                        ->whereIn('status', ['pending', 'verifying'])
                        ->first();

        // JIKA ADA TAGIHAN PENDING: Update nilainya
        if ($pendingTx) {
            // Gunakan kode unik yang sudah ada di transaksi itu
            $uniqueCode = $pendingTx->unique_code ?? rand(1, 199);
            
            // Hitung total bayar yang baru
            $hargaSetelahDiskon = max(0, $amount - $discountAmount);
            $totalAmount = $hargaSetelahDiskon + $uniqueCode;

            // Update data transaksi lama di database
            $pendingTx->update([
                'promo_code_id'   => $promoCodeId,
                'discount_amount' => $discountAmount,
                'total_amount'    => $totalAmount,
                'invoice_number'  => $pendingTx->invoice_number ?? 'INV-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5)),
                'payment_method'  => 'qris',
            ]);

            // --- PERBAIKAN BUG PESAN REDIRECT ---
            // Jika user benar-benar pakai promo, kasih pesan sukses warna hijau
            if ($promoCodeId) {
                return redirect()->route('payment.qris', $pendingTx->invoice_number)
                    ->with('success', 'Tagihan Anda berhasil diperbarui menggunakan kode promo.');
            } 
            // Jika tidak pakai promo, kasih pesan info biasa warna biru
            else {
                return redirect()->route('payment.qris', $pendingTx->invoice_number)
                    ->with('info', 'Silakan selesaikan pembayaran Anda.');
            }
        }

        // --- 3. JIKA TIDAK ADA TAGIHAN PENDING (BUAT TRANSAKSI FRESH BARU) ---
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
        $uniqueCode = rand(1, 199); 
        
        $hargaSetelahDiskon = max(0, $amount - $discountAmount);
        $totalAmount = $hargaSetelahDiskon + $uniqueCode;
        $expiredAt = now()->addHours(24); 

        $transaction = Transaction::create([
            'user_id'        => $userId,
            'tryout_id'      => $tryoutId,
            'order_id'       => $invoiceNumber,
            'invoice_number' => $invoiceNumber,
            'promo_code_id'  => $promoCodeId,       
            'amount'         => $amount,            
            'discount_amount'=> $discountAmount,    
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
        // $adminEmails = ['fenthalari@gmail.com','marsasefta02@gmail.com'];

        // Kirim notifikasi menggunakan facade Notification Laravel
        // Notification::route('mail', $adminEmails)->notify(new AdminPaymentNotification($transaction));
    
        // 1. Ambil email user yang sedang login (yang sedang upload bukti)
        $currentUserEmail = Auth::user()->email;

        // 2. Cek apakah user ini ADALAH akun ujicoba atau bukan
        // Jika BUKAN fenthalari@gmail.com, maka jalankan pengiriman email
        if ($currentUserEmail !== 'fenthalari@gmail.com') {
            
            $adminEmails = ['fenthalari@gmail.com','marsasefta02@gmail.com'];
            
            // Kirim notifikasi
            Notification::route('mail', $adminEmails)->notify(new AdminPaymentNotification($transaction));
        }
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

    public function checkStatus(Request $request)
    {
        // Ambil transaksi terakhir milik user yang sedang login
        $transaction = \App\Models\Transaction::where('user_id', auth()->id())
                        ->latest()
                        ->first();

        if ($transaction) {
            return response()->json([
                'status' => $transaction->status // Mengembalikan 'pending', 'success', atau 'failed'
            ]);
        }

        return response()->json(['status' => 'not_found'], 404);
    }

    public function checkPromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        // Cari promo, abaikan huruf besar/kecil (strtoupper), dan WAJIB bersatus 'aktif'
        $promo = PromoCode::where('code', strtoupper($request->code))
                        ->where('status', 'aktif') // <--- INI KUNCI PERBAIKANNYA
                        ->first();

        // Jika kode tidak ada atau statusnya bukan 'aktif'
        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak valid atau sudah kadaluarsa.'
            ]);
        }

        // Jika sukses
        return response()->json([
            'success' => true,
            'promo_id' => $promo->id,
            'discount_amount' => $promo->discount_amount,
            'message' => 'Kode promo berhasil diterapkan!'
        ]);
    }

    public function pilihPaket()
    {
        $user = auth()->user();

        // 1. Cek status kepemilikan paket
        $hasPaket1 = Transaction::where('user_id', $user->id)->where('tryout_id', 1)->where('status', 'Success')->exists();
        $hasPaket3 = Transaction::where('user_id', $user->id)->where('tryout_id', 3)->where('status', 'Success')->exists();
        $hasPaketLengkap = Transaction::where('user_id', $user->id)->where('tryout_id', 2)->where('status', 'Success')->exists();

        // User dianggap sudah punya Paket Lengkap jika beli langsung (ID 2) atau hasil upgrade (ID 1 + 3)
        $isLengkap = $hasPaketLengkap || ($hasPaket1 && $hasPaket3);

        // 2. Ambil Data Judul Paket dari Database
        // Menggunakan path lengkap \App\Models\Tryout untuk berjaga-jaga jika kamu belum menambahkan 'use App\Models\Tryout;' di atas
        $tryoutMandiri = Tryout::find(1);
        $tryoutLengkap = Tryout::find(2);

        // 3. Lempar semua variabel ke view
        return view('user.payment.pilih-paket', compact(
            'hasPaket1', 
            'isLengkap', 
            'tryoutMandiri', 
            'tryoutLengkap'
        ));
    }
}
