<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LearningCategory;
use App\Models\LearningMaterial;
use App\Models\LearningChapter;

class MateriController extends Controller
{
    // Method untuk halaman Lobby (Menampilkan 3 Kategori)
    public function index()
    {
        // Mengambil semua data kategori dari database
        // Kita juga bisa sekalian menghitung total materi jika ingin (opsional)
        $categories = LearningCategory::withCount('materials')->get();

        return view('user.materi.index', compact('categories'));
    }

    // Method untuk halaman Micro-Learning (Saat salah satu kategori diklik)
    public function show($categorySlug, $materialSlug = null)
    {
        $category = LearningCategory::where('slug', $categorySlug)->firstOrFail();
        $chapters = $category->chapters()->with('materials')->orderBy('order_number')->get();

        // 1. Tentukan materi aktif
        if ($materialSlug) {
            $currentMaterial = LearningMaterial::where('slug', $materialSlug)->firstOrFail();
        } else {
            $currentMaterial = $category->chapters->first()->materials->first();
        }

        // 2. LOGIKA PINTAR: Cari materi berikutnya
        // A. Coba cari materi selanjutnya di bab yang sama
        $nextMaterial = LearningMaterial::where('learning_chapter_id', $currentMaterial->learning_chapter_id)
            ->where('order_number', '>', $currentMaterial->order_number)
            ->orderBy('order_number', 'asc')
            ->first();

        // B. Jika di bab yang sama tidak ada (berarti sudah di akhir bab), 
        // cari bab selanjutnya lalu ambil materi pertama di bab tersebut
        if (!$nextMaterial) {
            $currentChapter = LearningChapter::find($currentMaterial->learning_chapter_id);
            
            $nextChapter = LearningChapter::where('learning_category_id', $category->id)
                ->where('order_number', '>', $currentChapter->order_number)
                ->orderBy('order_number', 'asc')
                ->first();

            if ($nextChapter) {
                $nextMaterial = $nextChapter->materials()->orderBy('order_number', 'asc')->first();
            }
        }

        return view('user.materi.show', compact('category', 'chapters', 'currentMaterial', 'nextMaterial'));
    }
}
