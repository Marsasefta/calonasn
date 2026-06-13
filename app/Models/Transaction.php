<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'tryout_id',
        'order_id',        
        'invoice_number',  
        'promo_code_id',   // TAMBAHAN BARU: ID dari tabel promo_codes
        'amount',          
        'discount_amount', // TAMBAHAN BARU: Nominal diskon
        'unique_code',     
        'total_amount',    
        'payment_method',  
        'payment_proof',   
        'status',          
        'expired_at',      
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public static function deleteExpiredPendingPayments()
    {
        return self::whereIn('status', ['pending', 'verifying'])
            ->whereNull('payment_proof')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->delete();
    }

    public static function deleteExpiredPendingPaymentsForUser($userId)
    {
        return self::where('user_id', $userId)
            ->whereIn('status', ['pending', 'verifying'])
            ->whereNull('payment_proof')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->delete();
    }

    public function isExpiredPending()
    {
        return in_array($this->status, ['pending', 'verifying'])
            && $this->expired_at
            && $this->expired_at->isPast()
            && !$this->payment_proof;
    }

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
