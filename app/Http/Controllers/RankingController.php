<?php

namespace App\Http\Controllers;

use App\Models\ExamSession;

class RankingController extends Controller
{
    public function index()
    {
        // 1. Ambil sesi ujian yang sudah selesai, diurutkan sesuai Standar BKN:
        // Prioritas: Total Skor DESC -> Skor TKP DESC -> Skor TIU DESC -> Skor TWK DESC
        $sessions = ExamSession::with('user')
            ->whereNotNull('end_time')
            ->orderByDesc('total_score')
            ->orderByDesc('score_tkp')
            ->orderByDesc('score_tiu')
            ->orderByDesc('score_twk')
            ->get();

        // 2. Ambil 1 sesi skor tertinggi per user (Deduplikasi agar 1 orang tidak muncul berulang)
        $uniqueSessions = $sessions->unique('user_id')->values();

        // 3. Mapping data peringkat lengkap dengan kalkulasi Passing Grade (TWK >= 65, TIU >= 80, TKP >= 166)
        $rankings = $uniqueSessions->map(function ($session, $index) {
            $duration = '-';
            if ($session->start_time && $session->end_time) {
                $seconds = abs($session->end_time->diffInSeconds($session->start_time));
                $minutes = intdiv($seconds, 60);
                $secondsRemaining = $seconds % 60;
                $duration = sprintf('%d Menit %02d Detik', $minutes, $secondsRemaining);
            }

            $twk = $session->score_twk ?? 0;
            $tiu = $session->score_tiu ?? 0;
            $tkp = $session->score_tkp ?? 0;
            $total = $session->total_score ?? 0;

            // Standar Passing Grade SKD Resmi BKN
            $isPassed = ($twk >= 65 && $tiu >= 80 && $tkp >= 166);

            return [
                'rank' => $index + 1,
                'user_id' => $session->user_id,
                'name' => $session->user->name ?? 'Peserta',
                'twk' => $twk,
                'tiu' => $tiu,
                'tkp' => $tkp,
                'total' => $total,
                'time' => $duration,
                'is_passed' => $isPassed,
            ];
        })->toArray();

        // 4. Cari posisi peringkat user yang sedang login
        $myUserId = auth()->id();
        $myRank = collect($rankings)->firstWhere('user_id', $myUserId);
        $totalParticipants = count($rankings);

        return view('user.rangking.ranking', compact('rankings', 'myRank', 'totalParticipants'));
    }
}
