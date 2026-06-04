<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MateriController extends Controller
{
    // Method untuk halaman Lobby (Menampilkan 3 Kategori)
    public function index()
    {
        // DATA DUMMY KATEGORI (Meniru tabel learning_categories)
        $categories = [
            [
                'id' => 1,
                'name' => 'Tes Wawasan Kebangsaan (TWK)',
                'slug' => 'twk',
                'description' => 'Kuasai Sejarah Indonesia, Pancasila, UUD 1945, dan Nasionalisme.',
                'icon' => 'bi-book',
                'color_theme' => 'danger', // Merah
                'total_pages' => 79 // Bonus info untuk UI
            ],
            [
                'id' => 2,
                'name' => 'Tes Inteligensia Umum (TIU)',
                'slug' => 'tiu',
                'description' => 'Taklukkan Logika, Deret Angka, Silogisme, dan Analogi Kata.',
                'icon' => 'bi-calculator',
                'color_theme' => 'primary', // Biru
                'total_pages' => 54
            ],
            [
                'id' => 3,
                'name' => 'Tes Karakteristik Pribadi (TKP)',
                'slug' => 'tkp',
                'description' => 'Pahami Karakter, Pelayanan Publik, dan Profesionalisme Kerja.',
                'icon' => 'bi-people',
                'color_theme' => 'success', // Hijau
                'total_pages' => 62
            ]
        ];

        // Lempar data dummy ke view lobby
        return view('user.materi.index', compact('categories'));
    }

    // Method untuk halaman Micro-Learning (Saat salah satu kategori diklik)
    public function show($slug)
    {
        // 1. Nama Kategori (Hanya untuk display dummy)
        $categoryName = strtoupper($slug);

        // 2. Data Dummy Bab & Materi (Meniru Relasi Database)
        $chapters = [
            [
                'id' => 1,
                'title' => 'Bab 1: Pancasila',
                'materials' => [
                    ['id' => 101, 'title' => 'Sejarah Lahirnya Pancasila', 'is_locked' => false, 'active' => true],
                    ['id' => 102, 'title' => 'Kedudukan & Fungsi Pancasila', 'is_locked' => false, 'active' => false],
                ]
            ],
            [
                'id' => 2,
                'title' => 'Bab 2: UUD 1945',
                'materials' => [
                    ['id' => 201, 'title' => 'Sejarah Amandemen', 'is_locked' => true, 'active' => false],
                    ['id' => 202, 'title' => 'Pasal-pasal Krusial', 'is_locked' => true, 'active' => false],
                ]
            ]
        ];

        return view('user.materi.show', compact('slug', 'categoryName', 'chapters'));
    }
}
