<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningChapter extends Model
{
    use HasFactory;

    protected $fillable = ['learning_category_id','title','order_number'];

    public function category()
    {
        return $this->belongsTo(LearningCategory::class, 'learning_category_id');
    }

    public function materials()
    {
        return $this->hasMany(LearningMaterial::class);
    }
}
