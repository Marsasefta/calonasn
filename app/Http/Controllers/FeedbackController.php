<?php

namespace App\Http\Controllers;

use App\Models\ExamSession;
use App\Models\TryoutFeedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, int $sessionId)
    {
        $userId = auth()->id();

        $session = ExamSession::where('id', $sessionId)
            ->where('user_id', $userId)
            ->whereNotNull('end_time')
            ->firstOrFail();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'recommendation' => ['required', 'in:yes,maybe,no'],
            'message' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'rating.required' => 'Pilih penilaian bintang terlebih dahulu.',
            'recommendation.required' => 'Pilih kesediaan merekomendasikan CalonASN.id.',
            'message.required' => 'Tulis masukan, testimoni, atau kritik & saranmu.',
            'message.min' => 'Masukan minimal 5 karakter ya.',
        ]);

        $existing = TryoutFeedback::where('user_id', $userId)->first();
        if ($existing) {
            $msg = 'Kamu sudah pernah mengisi feedback sebelumnya. Terima kasih atas masukanmu!';
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'already_submitted',
                    'message' => $msg,
                    'feedback' => [
                        'rating' => $existing->rating,
                        'recommendation' => $existing->recommendation,
                        'message' => $existing->message,
                    ],
                ], 409);
            }

            return back()->with('feedback_success', $msg);
        }

        $isPassed = ($session->score_twk >= 65 && $session->score_tiu >= 80 && $session->score_tkp >= 166);

        $feedback = TryoutFeedback::create([
            'user_id' => $userId,
            'exam_session_id' => $session->id,
            'rating' => (int) $validated['rating'],
            'recommendation' => $validated['recommendation'],
            'message' => trim($validated['message']),
            'is_passed' => $isPassed,
            'total_score' => (int) ($session->total_score ?? 0),
            'is_published' => false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Terima kasih! Masukanmu sangat berarti bagi CalonASN.id.',
                'feedback' => [
                    'rating' => $feedback->rating,
                    'recommendation' => $feedback->recommendation,
                    'message' => $feedback->message,
                ],
            ]);
        }

        return back()->with('feedback_success', 'Terima kasih! Masukan dan penilaianmu berhasil disimpan.');
    }

    public function adminIndex()
    {
        $feedbacks = TryoutFeedback::with(['user', 'examSession.tryout'])
            ->latest()
            ->get();

        $totalFeedback = $feedbacks->count();
        $avgRating = $totalFeedback > 0 ? round($feedbacks->avg('rating'), 1) : 0;
        $recommendYesCount = $feedbacks->where('recommendation', 'yes')->count();
        $recommendRate = $totalFeedback > 0 ? (int) round(($recommendYesCount / $totalFeedback) * 100) : 0;
        $publishedCount = $feedbacks->where('is_published', true)->count();

        return view('admin.feedback', compact(
            'feedbacks',
            'totalFeedback',
            'avgRating',
            'recommendYesCount',
            'recommendRate',
            'publishedCount'
        ));
    }

    public function togglePublish(int $id)
    {
        $feedback = TryoutFeedback::findOrFail($id);
        $feedback->is_published = !$feedback->is_published;
        $feedback->save();

        $msg = $feedback->is_published
            ? 'Testimoni berhasil ditayangkan di halaman depan.'
            : 'Testimoni disembunyikan dari halaman depan.';

        return back()->with('success', $msg);
    }

    public function destroy(int $id)
    {
        $feedback = TryoutFeedback::findOrFail($id);
        $feedback->delete();

        return back()->with('success', 'Data feedback berhasil dihapus.');
    }
}
