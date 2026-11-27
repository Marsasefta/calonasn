<?php

namespace App\Http\Controllers;

use App\Notifications\PaymentSuccessNotification;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        Transaction::deleteExpiredPendingPayments();

        $transactions = Transaction::with(['user', 'tryout'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function (Transaction $tx) {
                $tx->wa_url = $this->buildPendingWhatsappUrl($tx);
                return $tx;
            });

        $pendingCount = $transactions->whereIn('status', ['pending', 'verifying'])->count();
        $successCount = $transactions->where('status', 'success')->count();

        return view('admin.transactions', compact('transactions', 'pendingCount', 'successCount'));
    }

    private function buildPendingWhatsappUrl(Transaction $transaction): ?string
    {
        if (!in_array($transaction->status, ['pending', 'verifying'], true) || !$transaction->user) {
            return null;
        }

        $waNumber = \App\Models\User::normalizeWhatsappNumber($transaction->user->phone, '62');
        if ($waNumber === null) {
            return null;
        }

        $name = $transaction->user->name ?? 'Kak';
        $paket = $transaction->tryout->title ?? 'Paket Tryout CalonASN.id';
        $invoice = $transaction->invoice_number ?? $transaction->order_id ?? ('#TRX-' . $transaction->id);
        $nominal = number_format((int) $transaction->total_amount, 0, ',', '.');
        $payUrl = $transaction->invoice_number
            ? route('payment.qris', $transaction->invoice_number)
            : route('user.pilih-paket');
        $urgencyLine = ((int) $transaction->discount_amount > 0)
            ? 'Jangan sampai lewat batas waktu agar harga diskonnya tidak hangus ya.'
            : 'Jangan sampai lewat batas waktu agar tagihan tidak kedaluwarsa dan tidak perlu mengulang dari awal.';

        $message = "Halo Kak {$name}, Admin CalonASN.id di sini 😊\n\n"
            . "Pesanan *{$paket}* Kakak (*{$invoice}*) sebesar *Rp {$nominal}* masih menunggu pembayaran ya. {$urgencyLine}\n\n"
            . "Biar cepat aktif tanpa ribet:\n"
            . "👉 Link QRIS: {$payUrl}\n"
            . "👉 Transfer pas *Rp {$nominal}*\n"
            . "👉 Upload bukti di web atau *kirim screenshot-nya langsung ke WA ini*, biar langsung saya aktifkan sekarang ⚡\n\n"
            . 'Ada kendala saat buka QRIS-nya Kak?';

        return 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($message);
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
