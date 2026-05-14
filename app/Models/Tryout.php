<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'duration_minutes',
        'schedule_at',
        'is_active',
        'status',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'schedule_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
