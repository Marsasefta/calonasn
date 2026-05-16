<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'tryout_id',
        'order_id',        // Tetap dibiarkan jika kolomnya tidak dihapus di database
        'invoice_number',  // Kolom baru untuk nomor invoice manual
        'amount',          // Harga asli
        'unique_code',     // 3 digit kode unik
        'total_amount',    // Total transfer (Harga + Kode unik)
        'payment_method',  // Metode pembayaran (qris)
        'payment_proof',   // Nama file gambar bukti transfer
        'status',          // pending, verifying, paid, failed
        'expired_at',      // Batas waktu transfer
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Tryout
    public function tryout()
    {
        return $this->belongsTo(Tryout::class); // Pastikan Model Tryout sudah dibuat nanti
    }
}
