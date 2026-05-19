<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        // Data dummy untuk simulasi ranking
        $rankings = [
            ['rank' => 1, 'name' => 'Siti Aminah', 'twk' => 145, 'tiu' => 170, 'tkp' => 183, 'total' => 498, 'time' => '82 Menit'],
            ['rank' => 2, 'name' => 'Ahmad Fauzi', 'twk' => 140, 'tiu' => 165, 'tkp' => 180, 'total' => 485, 'time' => '85 Menit'],
            ['rank' => 3, 'name' => 'Budi Santoso', 'twk' => 135, 'tiu' => 160, 'tkp' => 177, 'total' => 472, 'time' => '88 Menit'],
            ['rank' => 4, 'name' => 'Dian Puspita', 'twk' => 140, 'tiu' => 150, 'tkp' => 180, 'total' => 470, 'time' => '90 Menit'],
            ['rank' => 5, 'name' => 'Eko Prasetyo', 'twk' => 135, 'tiu' => 140, 'tkp' => 175, 'total' => 450, 'time' => '88 Menit'],
        ];

        return view('user.rangking.ranking', compact('rankings'));
    }
}
