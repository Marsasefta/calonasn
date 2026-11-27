<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutFeedback extends Model
{
    protected $table = 'tryout_feedbacks';

    protected $fillable = [
        'user_id',
        'exam_session_id',
        'rating',
        'recommendation',
        'message',
        'is_passed',
        'total_score',
        'is_published',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_passed' => 'boolean',
        'total_score' => 'integer',
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examSession()
    {
        return $this->belongsTo(ExamSession::class);
    }

    /**
     * Samarkan sebagian nama peserta untuk privasi di halaman depan (mis. "Andri S.").
     */
    public function maskedAuthorName(): string
    {
        return $this->user?->maskedName() ?? 'Peserta CalonASN';
    }
}
