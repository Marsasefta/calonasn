<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalImport implements ToCollection, WithHeadingRow
{
    protected $tryoutId;
    protected $categories;
    protected $existingQuestions; 
    
    public $rowCountSukses = 0;
    public $rowCountGagal = 0;
    public $rowCountDuplikat = 0; 

    public function __construct($tryoutId)
    {
        $this->tryoutId = $tryoutId;
        $this->categories = Category::all()->keyBy(function($item) {
            return strtoupper(trim($item->name));
        });

        // Simpan memori soal yang sudah ada di database ke dalam array
        $this->existingQuestions = Question::where('tryout_id', $tryoutId)
            ->pluck('question_text')
            ->map(function($text) {
                return strtolower(trim($text));
            })
            ->toArray();
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // 1. Cek Pertanyaan Kosong
            if (empty($row['pertanyaan'])) {
                $this->rowCountGagal++;
                continue;
            }

            // 2. CEK DUPLIKAT (Filter Utama)
            $teksSoalNormal = strtolower(trim($row['pertanyaan']));
            
            if (in_array($teksSoalNormal, $this->existingQuestions)) {
                $this->rowCountDuplikat++; // Hitung sebagai duplikat
                continue; // Hentikan proses untuk baris ini, lanjut ke baris berikutnya
            }

            // Masukkan soal baru ini ke memori agar kalau ada soal kembar di baris bawahnya, langsung tertolak
            $this->existingQuestions[] = $teksSoalNormal;

            // 3. Cek Kategori
            $catName = strtoupper(trim($row['kategori']));
            $categoryId = $this->categories->has($catName) ? $this->categories[$catName]->id : null;

            if (!$categoryId) {
                $this->rowCountGagal++;
                continue;
            }

            // 4. Lolos Semua Filter -> Simpan ke Database
            $question = Question::create([
                'tryout_id'     => $this->tryoutId,
                'category_id'   => $categoryId,
                'question_text' => $row['pertanyaan'],
                'discussion'    => $row['pembahasan'] ?? null,
            ]);

            $options = [
                ['text' => $row['opsi_a'], 'point' => $row['poin_a']],
                ['text' => $row['opsi_b'], 'point' => $row['poin_b']],
                ['text' => $row['opsi_c'], 'point' => $row['poin_c']],
                ['text' => $row['opsi_d'], 'point' => $row['poin_d']],
                ['text' => $row['opsi_e'], 'point' => $row['poin_e']],
            ];

            foreach ($options as $opt) {
                if (!empty($opt['text'])) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt['text'],
                        'point'       => $opt['point'] ?? 0,
                    ]);
                }
            }

            $this->rowCountSukses++;
        }
    }
}