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
