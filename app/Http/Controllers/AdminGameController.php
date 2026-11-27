<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminGameController extends Controller
{
    /**
     * Tampilkan halaman monitoring & manajemen leaderboard Zona Refreshing (Flappy ASN).
     */
    public function index(): View
    {
        $scores = GameScore::with('user')
            ->orderByDesc('best_score')
            ->orderByDesc('updated_at')
            ->get();

        $totalPlayers = $scores->count();
        $totalGamesPlayed = (int) $scores->sum('games_played');
        $topScore = $scores->first();
        $highestScore = (int) ($topScore->best_score ?? 0);
        $topPlayerName = $topScore?->user?->name ?? '-';
        $avgBestScore = $totalPlayers > 0 ? round((float) $scores->avg('best_score'), 1) : 0;

        $trialSeconds = RefreshingGameController::TRIAL_SECONDS;
        $trialDailyLimit = RefreshingGameController::TRIAL_DAILY_LIMIT;

        return view('admin.game.index', compact(
            'scores',
            'totalPlayers',
            'totalGamesPlayed',
            'highestScore',
            'topPlayerName',
            'avgBestScore',
            'trialSeconds',
            'trialDailyLimit'
        ));
    }

    /**
     * Hapus satu entri skor peserta dari leaderboard.
     */
    public function destroy(int $id): RedirectResponse
    {
        $score = GameScore::with('user')->findOrFail($id);
        $playerName = $score->user?->name ?? 'Peserta';
        $score->delete();

        return redirect()
            ->route('admin.game.index')
            ->with('success', "Skor Flappy ASN milik {$playerName} berhasil dihapus dari leaderboard.");
    }

    /**
     * Reset seluruh skor leaderboard Zona Refreshing.
     */
    public function resetAll(): RedirectResponse
    {
        $deletedCount = GameScore::query()->delete();

        return redirect()
            ->route('admin.game.index')
            ->with('success', "Seluruh skor leaderboard berhasil direset ({$deletedCount} data dihapus).");
    }
}
