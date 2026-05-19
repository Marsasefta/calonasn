<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class DemoController extends Controller
{
    private function getDemoQuestions() 
    {
        // 1. Ambil 3 Soal TWK
        $twk = Question::with(['category', 'options'])
            ->whereHas('category', function($query) {
                $query->where('name', 'TWK');
            })
            ->orderBy('id', 'asc')
            ->take(3)
            ->get();

        // 2. Ambil 3 Soal TIU
        $tiu = Question::with(['category', 'options'])
            ->whereHas('category', function($query) {
                $query->where('name', 'TIU');
            })
            ->orderBy('id', 'asc')
            ->take(3)
            ->get();

        // 3. Ambil 4 Soal TKP
        $tkp = Question::with(['category', 'options'])
            ->whereHas('category', function($query) {
                $query->where('name', 'TKP');
            })
            ->orderBy('id', 'asc')
            ->take(4)
            ->get();

        // --- FIX: Gabungkan semua hasil query menjadi satu koleksi ---
        $allQuestions = $twk->concat($tiu)->concat($tkp);

        $formattedQuestions = [];
        $nomor = 1;

        foreach ($allQuestions as $q) {
            $opsiTexts = $q->options->pluck('option_text')->toArray();
            
            // CARI OPSI YANG POINT-NYA 5
            $opsiBenar = $q->options->where('point', 5)->first();
            
            $formattedQuestions[] = [
                'id'         => $nomor,
                'kategori'   => $q->category->name ?? 'UMUM',
                'pertanyaan' => $q->question_text,
                'opsi'       => $opsiTexts,
                // Jika ketemu yang point 5, pakai itu. Jika tidak, pakai opsi pertama (index 0)
                'kunci'      => $opsiBenar ? $opsiBenar->option_text : ($opsiTexts[0] ?? ''),
                'pembahasan' => $q->discussion ?? 'Pembahasan belum tersedia.'
            ];
            
            $nomor++;
        }

        return $formattedQuestions;
    }

    public function index() {
        return view('user.demo.index');
    }

    public function start() {
        $questions = $this->getDemoQuestions();
        return view('user.demo.exam', compact('questions'));
    }

    public function finish(Request $request) {
        // 1. Ambil data soal
        $questions = $this->getDemoQuestions();
        
        // 2. Ambil jawaban dari user
        $answers = $request->input('jawaban', []);
        
        $correct = 0;
        $detailHasil = []; 

        foreach($questions as $q) {
            $jawabanUser = isset($answers[$q['id']]) ? $answers[$q['id']] : null;
            
            $isCorrect = (strtolower(trim($jawabanUser)) === strtolower(trim($q['kunci'])));
            
            if($isCorrect) {
                $correct++;
            }

            $detailHasil[] = [
                'no' => $q['id'],
                'user' => $jawabanUser,
                'kunci' => $q['kunci'],
                'status' => $isCorrect
            ];
        }

        $totalSoal = count($questions);

        // --- PERBAIKAN DI SINI ---
        // Mengubah dari sistem persentase ke standar poin CAT BKN (1 soal = 5 poin)
        $score = $correct * 5;

        return view('user.demo.result', compact('correct', 'score', 'totalSoal', 'detailHasil'));
    }

}
