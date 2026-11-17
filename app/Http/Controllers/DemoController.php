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

        $twkTotal = 0;
        $tiuTotal = 0;
        $tkpTotal = 0;
        $twkCorrect = 0;
        $tiuCorrect = 0;
        $tkpCorrect = 0;

        foreach($questions as $q) {
            $cat = strtoupper(trim($q['kategori'] ?? ''));
            if ($cat === 'TWK') $twkTotal++;
            elseif ($cat === 'TIU') $tiuTotal++;
            elseif ($cat === 'TKP') $tkpTotal++;

            $jawabanUser = isset($answers[$q['id']]) ? $answers[$q['id']] : null;
            
            $isCorrect = (strtolower(trim($jawabanUser)) === strtolower(trim($q['kunci'])));
            
            if($isCorrect) {
                $correct++;
                if ($cat === 'TWK') $twkCorrect++;
                elseif ($cat === 'TIU') $tiuCorrect++;
                elseif ($cat === 'TKP') $tkpCorrect++;
            }

            $detailHasil[] = [
                'no' => $q['id'],
                'kategori' => $q['kategori'] ?? 'UMUM',
                'pertanyaan' => \Illuminate\Support\Str::limit(strip_tags($q['pertanyaan']), 80),
                'user' => $jawabanUser,
                'kunci' => $q['kunci'],
                'status' => $isCorrect
            ];
        }

        $totalSoal = count($questions);

        // Standar poin CAT BKN untuk demo (1 soal = 5 poin)
        $score = $correct * 5;

        // Cek status paket user
        $user = auth()->user();
        $hasPaket1 = false;
        $hasPaket3 = false;
        $hasPaketLengkap = false;
        $isLengkap = false;

        if ($user) {
            $hasPaket1 = \App\Models\Transaction::where('user_id', $user->id)->where('tryout_id', 1)->where('status', 'Success')->exists();
            $hasPaket3 = \App\Models\Transaction::where('user_id', $user->id)->where('tryout_id', 3)->where('status', 'Success')->exists();
            $hasPaketLengkap = \App\Models\Transaction::where('user_id', $user->id)->where('tryout_id', 2)->where('status', 'Success')->exists();
            $isLengkap = $hasPaketLengkap || ($hasPaket1 && $hasPaket3);
        }

        return view('user.demo.result', compact(
            'correct', 
            'score', 
            'totalSoal', 
            'detailHasil',
            'twkTotal',
            'tiuTotal',
            'tkpTotal',
            'twkCorrect',
            'tiuCorrect',
            'tkpCorrect',
            'hasPaket1',
            'isLengkap'
        ));
    }

}
