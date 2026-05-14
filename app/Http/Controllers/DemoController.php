<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    private function getDemoQuestions() {
        return [ 
            ['id' => 1, 'type' => 'TWK', 'q' => 'Lambang negara Indonesia adalah...', 'a' => 'Garuda Pancasila', 'options' => ['Garuda Pancasila', 'Beringin', 'Rantai', 'Padi Kapas']],
            ['id' => 2, 'type' => 'TIU', 'q' => '1, 4, 9, 16, ...', 'a' => '25', 'options' => ['20', '25', '30', '36']],
            ['id' => 3, 'type' => 'TKP', 'q' => 'Jika rekan kerja Anda kesulitan, apa yang Anda lakukan?', 'a' => 'Membantunya setelah tugas saya selesai', 'options' => ['Membiarkannya', 'Membantunya setelah tugas saya selesai', 'Melaporkan ke atasan', 'Menertawakannya']],
            ['id' => 4, 'type' => 'TWK', 'q' => 'Siapakah ketua BPUPKI?', 'a' => 'Dr. Radjiman Wedyodiningrat', 'options' => ['Ir. Soekarno', 'Moh. Hatta', 'Dr. Radjiman Wedyodiningrat', 'Mr. Muhammad Yamin']],
            ['id' => 5, 'type' => 'TIU', 'q' => 'HUTAN : POHON = ... : ...', 'a' => 'ARMADA : KAPAL', 'options' => ['MAWAR : DURI', 'ARMADA : KAPAL', 'KAMAR : RUMAH', 'RAK : BUKU']],
            ['id' => 6, 'type' => 'TKP', 'q' => 'Saat sedang sibuk, atasan memberikan tugas tambahan yang mendadak. Sikap Anda...', 'a' => 'Menerimanya dan mengatur skala prioritas', 'options' => ['Menolaknya dengan halus', 'Mengerjakannya asal-asalan', 'Menerimanya dan mengatur skala prioritas', 'Mengeluh di media sosial']],
            ['id' => 7, 'type' => 'TWK', 'q' => 'Sumpah Pemuda dibacakan pada tanggal...', 'a' => '28 Oktober 1928', 'options' => ['17 Agustus 1945', '20 Mei 1908', '28 Oktober 1928', '1 Juni 1945']],
            ['id' => 8, 'type' => 'TIU', 'q' => 'Jika x = 2 dan y = 3, maka hasil dari 2x + 3y adalah...', 'a' => '13', 'options' => ['10', '12', '13', '15']],
            ['id' => 9, 'type' => 'TKP', 'q' => 'Ada sistem aplikasi baru di kantor, namun Anda belum paham cara pakainya. Anda akan...', 'a' => 'Mempelajarinya secara mandiri dan antusias', 'options' => ['Menunggu pelatihan resmi', 'Mempelajarinya secara mandiri dan antusias', 'Meminta rekan lain mengerjakannya', 'Mengabaikannya']],
            ['id' => 10, 'type' => 'TWK', 'q' => 'UUD 1945 telah mengalami amandemen sebanyak...', 'a' => '4 Kali', 'options' => ['1 Kali', '2 Kali', '3 Kali', '4 Kali']],
        ];
    }

    public function index() {
        return view('user.demo.index');
    }

    public function start() {
        $questions = $this->getDemoQuestions();
        return view('user.demo.exam', compact('questions'));
    }

    public function finish(Request $request) {
        $questions = $this->getDemoQuestions();
        $answers = $request->input('answers');
        $correct = 0;
        
        foreach($questions as $q) {
            if(isset($answers[$q['id']]) && $answers[$q['id']] == $q['a']) {
                $correct++;
            }
        }

        $score = $correct * 10; // Skor sederhana
        return view('user.demo.result', compact('correct', 'score'));
    }
}
