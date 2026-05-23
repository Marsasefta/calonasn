<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'promo_codes';

    // Kolom yang diizinkan untuk diisi
    protected $fillable = [
        'code',
        'discount_amount',
        'status'
    ];
}