<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    protected $transaction;

    // Menerima data transaksi dari Controller
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Sesuaikan route('dashboard') dengan nama route halaman utama member kamu
        $urlMulaiUjian = route('dashboard'); 

        return (new MailMessage)
                    ->subject('Hore! Akses Tryout Premium Sudah Aktif 🎉')
                    ->greeting('Halo, ' . $notifiable->name . '!')
                    ->line('Terima kasih! Pembayaran kamu untuk invoice ' . $this->transaction->invoice_number . ' telah berhasil kami konfirmasi.')
                    ->line('Status akun kamu sekarang sudah menjadi PREMIUM. Semua fitur simulasi CAT BKN, skor real-time, dan kunci pembahasan sudah terbuka dan siap digunakan.')
                    ->action('Mulai Ujian Sekarang', $urlMulaiUjian)
                    ->line('Tetap semangat belajarnya, mari kita kejar NIP tahun ini!')
                    ->salutation('Salam hangat, Tim CalonASN.id');
    }
}