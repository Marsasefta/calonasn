<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPaymentNotification extends Notification
{
    use Queueable;

    protected $transaction;

    // 1. Tangkap data transaksi dari controller
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    // 2. Tentukan media pengiriman via Email (Mail)
    public function via($notifiable)
    {
        return ['mail'];
    }

    // 3. Struktur isi email khusus Admin (Anti-Spam Optimization)
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Konfirmasi Pembayaran Baru: Invoice #' . $this->transaction->invoice_number)
                    ->greeting('Halo Admin CalonASN.id,')
                    ->line('Seorang peserta telah mengunggah bukti pembayaran untuk paket tryout.')
                    ->line('Berikut adalah detail transaksinya:')
                    ->line('• No. Invoice: ' . $this->transaction->invoice_number)
                    ->line('• Total Pembayaran: Rp ' . number_format($this->transaction->total_amount, 0, ',', '.'))
                    ->action('Verifikasi Pembayaran', url('/login')) // Sesuaikan dengan URL admin kamu
                    ->line('Mohon segera lakukan pengecekan pada mutasi rekening/QRIS untuk mengaktifkan akses ujian user.');
    }
}
