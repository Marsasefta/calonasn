<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public const CATEGORIES = [
        'iklan' => 'Iklan / Ads',
        'server' => 'Server & Tools',
        'operasional' => 'Operasional / Lainnya',
    ];

    protected $fillable = [
        'expense_date',
        'name',
        'category',
        'amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'integer',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category);
    }
}
