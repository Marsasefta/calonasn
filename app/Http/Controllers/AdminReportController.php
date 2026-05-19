<?php

namespace App\Http\Controllers;

use App\Models\ExamSession;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = ExamSession::with(['user', 'tryout'])
            ->orderBy('total_score', 'desc')
            ->paginate(20);

        return view('admin.reports', compact('reports'));
    }

    public function export()
    {
        $filename = 'laporan_tryout_' . now()->format('Ymd_His') . '.csv';
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Nama Peserta', 'Tryout', 'Skor Total', 'Waktu Mulai', 'Waktu Selesai', 'Durasi (menit)']);

            ExamSession::with(['user', 'tryout'])->chunk(100, function ($sessions) use ($handle) {
                foreach ($sessions as $session) {
                    $start = $session->start_time ? $session->start_time->format('Y-m-d H:i') : '-';
                    $end = $session->end_time ? $session->end_time->format('Y-m-d H:i') : '-';
                    $duration = $session->start_time && $session->end_time ? $session->end_time->diffInMinutes($session->start_time) : '-';

                    fputcsv($handle, [
                        "'{$session->user->phone}",
                        $session->user->name,
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
