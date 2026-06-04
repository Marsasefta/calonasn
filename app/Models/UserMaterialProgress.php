<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMaterialProgress extends Model
{
    use HasFactory;

    protected $table = 'user_material_progress';

    protected $fillable = ['user_id','learning_material_id','completed_at'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function material()
    {
        return $this->belongsTo(LearningMaterial::class, 'learning_material_id');
    }
}
