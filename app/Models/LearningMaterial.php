<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['learning_chapter_id','title','slug','content','order_number','is_locked'];

    public function chapter()
    {
        return $this->belongsTo(LearningChapter::class, 'learning_chapter_id');
    }
}
