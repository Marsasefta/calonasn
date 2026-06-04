<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description','icon','color_theme'];

    public function chapters()
    {
        return $this->hasMany(LearningChapter::class);
    }
}
