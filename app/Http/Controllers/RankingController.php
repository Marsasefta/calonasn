<?php

namespace App\Http\Controllers;

use App\Models\ExamSession;

class RankingController extends Controller
{
    public function index()
    {
        $sessions = ExamSession::with('user')
            ->whereNotNull('end_time')
            ->orderByDesc('total_score')
            ->get();

        $rankings = $sessions->map(function ($session, $index) {
            $duration = '-';
            if ($session->start_time && $session->end_time) {
                $duration = $session->end_time->diffInMinutes($session->start_time) . ' Menit';
            }

            return [
                'rank' => $index + 1,
                'user_id' => $session->user_id,
                'name' => $session->user->name ?? 'Peserta',
                'twk' => $session->score_twk ?? 0,
                'tiu' => $session->score_tiu ?? 0,
                'tkp' => $session->score_tkp ?? 0,
                'total' => $session->total_score ?? 0,
                'time' => $duration,
            ];
        })->toArray();

        return view('user.rangking.ranking', compact('rankings'));
    }
}
