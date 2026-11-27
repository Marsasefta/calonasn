<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RefreshingGameController extends Controller
{
    public const TRIAL_SECONDS = 5;
    public const TRIAL_DAILY_LIMIT = 3;

    public function index()
    {
        $user = auth()->user();
        $hasFullAccess = $user->package_status !== 'free';
        $trialsUsed = $hasFullAccess ? 0 : $this->getTrialsUsed($user->id);
        $trialsRemaining = $hasFullAccess ? null : max(0, self::TRIAL_DAILY_LIMIT - $trialsUsed);

        $myRecord = GameScore::where('user_id', $user->id)->first();
        $myBestScore = (int) ($myRecord->best_score ?? 0);

        $leaderboard = $this->getLeaderboardData();
        $promo24h = $user->newMemberPromo();

        return view('user.game.index', [
            'hasFullAccess' => $hasFullAccess,
            'packageLabel' => $user->package_label,
            'trialSeconds' => self::TRIAL_SECONDS,
            'trialLimit' => self::TRIAL_DAILY_LIMIT,
            'trialsUsed' => $trialsUsed,
            'trialsRemaining' => $trialsRemaining,
            'myBestScore' => $myBestScore,
            'leaderboard' => $leaderboard,
            'promo24h' => $promo24h,
        ]);
    }

    public function consumeTrial()
    {
        $user = auth()->user();
        if ($user->package_status !== 'free') {
            return response()->json([
                'allowed' => true,
                'unlimited' => true,
            ]);
        }

        $key = $this->trialCacheKey($user->id);
        $used = $this->getTrialsUsed($user->id);

        if ($used >= self::TRIAL_DAILY_LIMIT) {
            return response()->json([
                'allowed' => false,
                'trials_used' => $used,
                'trials_remaining' => 0,
                'message' => 'Jatah 3x trial hari ini sudah habis. Upgrade ke Paket Tryout untuk main unlimited!',
            ], 429);
        }

        $newUsed = $used + 1;
        Cache::store('file')->put($key, $newUsed, now()->endOfDay());

        return response()->json([
            'allowed' => true,
            'unlimited' => false,
            'trials_used' => $newUsed,
            'trials_remaining' => max(0, self::TRIAL_DAILY_LIMIT - $newUsed),
        ]);
    }

    public function saveScore(Request $request)
    {
        $user = auth()->user();
        if ($user->package_status === 'free') {
            return response()->json([
                'status' => 'forbidden',
                'message' => 'Penyimpanan skor Leaderboard khusus untuk Member Paket Premium.',
            ], 403);
        }

        $validated = $request->validate([
            'score' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);

        $score = (int) $validated['score'];

        $record = GameScore::firstOrNew(['user_id' => $user->id]);
        $isNewBest = false;

        if (!$record->exists) {
            $record->best_score = $score;
            $record->games_played = 1;
            $isNewBest = $score > 0;
        } else {
            $record->games_played = (int) $record->games_played + 1;
            if ($score > (int) $record->best_score) {
                $record->best_score = $score;
                $isNewBest = true;
            }
        }
        $record->save();

        return response()->json([
            'status' => 'success',
            'best_score' => (int) $record->best_score,
            'is_new_best' => $isNewBest,
            'leaderboard' => $this->getLeaderboardData(),
        ]);
    }

    private function trialCacheKey(int $userId): string
    {
        return 'game_trials:' . now()->format('Y-m-d') . ':user_' . $userId;
    }

    private function getTrialsUsed(int $userId): int
    {
        return (int) Cache::store('file')->get($this->trialCacheKey($userId), 0);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function getLeaderboardData()
    {
        return GameScore::with('user')
            ->where('best_score', '>', 0)
            ->orderByDesc('best_score')
            ->orderBy('updated_at')
            ->take(10)
            ->get()
            ->values()
            ->map(function (GameScore $item, int $idx) {
                return [
                    'rank' => $idx + 1,
                    'user_id' => $item->user_id,
                    'name' => $item->user?->maskedName() ?? 'Pejuang ASN',
                    'best_score' => (int) $item->best_score,
                    'package_label' => $item->user?->package_label ?? 'Member',
                ];
            });
    }
}
