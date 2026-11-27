<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    protected $fillable = [
        'user_id',
        'best_score',
        'games_played',
    ];

    protected $casts = [
        'best_score' => 'integer',
        'games_played' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
