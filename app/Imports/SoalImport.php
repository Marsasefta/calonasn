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
    
    // Tambahkan variabel mesin penghitung di sini
    public $rowCountSukses = 0;
    public $rowCountGagal = 0;

    public function __construct($tryoutId)
    {
        $this->tryoutId = $tryoutId;
        $this->categories = Category::all()->keyBy(function($item) {
            return strtoupper(trim($item->name));
        });
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Jika pertanyaan kosong, hitung sebagai gagal dan lewati
            if (empty($row['pertanyaan'])) {
                $this->rowCountGagal++;
                continue;
            }

            $catName = strtoupper(trim($row['kategori']));
            $categoryId = $this->categories->has($catName) ? $this->categories[$catName]->id : null;

            // Jika kategori tidak ada di database, hitung sebagai gagal dan lewati
            if (!$categoryId) {
                $this->rowCountGagal++;
                continue;
            }

            // Jika aman, eksekusi penyimpanan soal
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

            // Jika sampai di titik ini, berarti soal sukses masuk database
            $this->rowCountSukses++;
        }
    }
}
