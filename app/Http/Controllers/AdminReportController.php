<?php

namespace App\Http\Controllers;

use App\Models\ExamAnswer;
use App\Models\ExamSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    public function index()
    {
        app(UjianController::class)->closeExpiredUnfinishedSessions();

        $reports = ExamSession::with(['user', 'tryout'])
            ->orderBy('total_score', 'desc')
            ->get();

        return view('admin.reports', compact('reports'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $session = ExamSession::with('user')->findOrFail($id);
        $userName = $session->user?->name ?? 'Peserta';

        ExamAnswer::where('exam_session_id', $session->id)->delete();
        $session->delete();

        return redirect()
            ->route('admin.reports.index')
            ->with('success', "Data laporan ujian milik {$userName} berhasil dihapus.");
    }

    public function export()
    {
        $filename = 'laporan_tryout_' . now()->format('Ymd_His') . '.csv';
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Nomor WhatsApp', 'Nama Peserta', 'Tryout', 'Skor Total', 'Waktu Mulai', 'Waktu Selesai', 'Durasi (menit)']);

            ExamSession::with(['user', 'tryout'])->chunk(100, function ($sessions) use ($handle) {
                foreach ($sessions as $session) {
                    $start = $session->start_time ? $session->start_time->format('Y-m-d H:i') : '-';
                    $end = $session->end_time ? $session->end_time->format('Y-m-d H:i') : '-';
                    $duration = $session->start_time && $session->end_time ? $session->end_time->diffInMinutes($session->start_time) : '-';
                    $phone = $session->user ? ($session->user->phone ? "'{$session->user->phone}" : '-') : '-';
                    $name = $session->user->name ?? 'Peserta';

                    fputcsv($handle, [
                        $phone,
                        $name,
                        $session->tryout->title ?? '-',
                        $session->total_score,
                        $start,
                        $end,
                        $duration,
                    ]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
