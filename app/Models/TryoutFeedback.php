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
        $rawName = trim((string) ($this->user->name ?? 'Peserta'));
        if ($rawName === '') {
            return 'Peserta CalonASN';
        }

        $parts = preg_split('/\s+/', $rawName) ?: [];
        if (count($parts) >= 2) {
            $first = mb_convert_case($parts[0], MB_CASE_TITLE, 'UTF-8');
            $initials = [];
            foreach (array_slice($parts, 1) as $part) {
                $char = mb_strtoupper(mb_substr($part, 0, 1, 'UTF-8'), 'UTF-8');
                if ($char !== '') {
                    $initials[] = $char . '.';
                }
            }

            return trim($first . ' ' . implode(' ', $initials));
        }

        $single = mb_convert_case($parts[0], MB_CASE_TITLE, 'UTF-8');
        $len = mb_strlen($single, 'UTF-8');
        if ($len <= 3) {
            return mb_substr($single, 0, 1, 'UTF-8') . '***';
        }

        return mb_substr($single, 0, 3, 'UTF-8') . '***';
    }
}
