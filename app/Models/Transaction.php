<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'tryout_id',
        'order_id',
        'amount',
        'status',
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
