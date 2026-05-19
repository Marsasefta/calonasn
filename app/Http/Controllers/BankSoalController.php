<?php

namespace App\Http\Controllers;

use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Tryout;
use Illuminate\Support\Facades\DB;

class BankSoalController extends Controller
{
    public function createBankSoal()
    {
        $tryouts = Tryout::orderBy('title')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.create_bank_soal', compact('tryouts', 'categories'));
    }

    public function storeBankSoal(Request $request)
    {
        $validated = $request->validate([
            'tryout_id' => 'required|exists:tryouts,id',
            'category_id' => 'required|exists:categories,id',
            'question_text' => 'required|string',
            'discussion' => 'nullable|string',
            'option_a' => 'required|string',
            'point_a' => 'required|integer|min:0|max:5',
            'option_b' => 'required|string',
            'point_b' => 'required|integer|min:0|max:5',
            'option_c' => 'required|string',
            'point_c' => 'required|integer|min:0|max:5',
            'option_d' => 'required|string',
            'point_d' => 'required|integer|min:0|max:5',
        ]);

        $question = Question::create([
            'tryout_id' => $validated['tryout_id'],
            'category_id' => $validated['category_id'],
            'question_text' => $validated['question_text'],
            'discussion' => $validated['discussion'] ?? null,
        ]);

        QuestionOption::create([
            'question_id' => $question->id,
            'option_text' => $validated['option_a'],
            'point' => $validated['point_a'],
        ]);
        QuestionOption::create([
            'question_id' => $question->id,
            'option_text' => $validated['option_b'],
            'point' => $validated['point_b'],
        ]);
        QuestionOption::create([
            'question_id' => $question->id,
            'option_text' => $validated['option_c'],
            'point' => $validated['point_c'],
        ]);
        QuestionOption::create([
            'question_id' => $question->id,
            'option_text' => $validated['option_d'],
            'point' => $validated['point_d'],
        ]);

        return back()->with('success', 'Bank soal berhasil disimpan.');
    }

    public function listBankSoal()
    {
        $tryouts = Tryout::orderBy('title')->get();
        $categories = Category::orderBy('name')->get();
        $questions = Question::with(['tryout', 'category', 'options'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.list_bank_soal', compact('questions', 'tryouts', 'categories'));
    }

    public function editBankSoal($id)
    {
        $question = Question::with('options')->findOrFail($id);
        $tryouts = Tryout::orderBy('title')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.edit_bank_soal', compact('question', 'tryouts', 'categories'));
    }

    public function updateBankSoal(Request $request, $id)
    {
        $validated = $request->validate([
            'tryout_id' => 'required|exists:tryouts,id',
            'category_id' => 'required|exists:categories,id',
            'question_text' => 'required|string',
            'discussion' => 'nullable|string',
            'option_a' => 'required|string',
            'point_a' => 'required|integer|min:0|max:5',
            'option_b' => 'required|string',
            'point_b' => 'required|integer|min:0|max:5',
            'option_c' => 'required|string',
            'point_c' => 'required|integer|min:0|max:5',
            'option_d' => 'required|string',
            'point_d' => 'required|integer|min:0|max:5',
        ]);

        $question = Question::findOrFail($id);
        
        $question->update([
            'tryout_id' => $validated['tryout_id'],
            'category_id' => $validated['category_id'],
            'question_text' => $validated['question_text'],
            'discussion' => $validated['discussion'] ?? null,
        ]);

        $options = $question->options()->get();
        $optionLetters = ['a', 'b', 'c', 'd'];
        
        foreach ($optionLetters as $index => $letter) {
            if (isset($options[$index])) {
                $options[$index]->update([
                    'option_text' => $validated['option_' . $letter],
                    'point' => $validated['point_' . $letter],
                ]);
            }
        }

        return redirect()->route('admin.list-bank-soal')->with('success', 'Bank soal berhasil diperbarui.');
    }

    public function destroyBankSoal($id)
    {
        $question = Question::findOrFail($id);
        $question->options()->delete();
        $question->delete();

        return back()->with('success', 'Bank soal berhasil dihapus.');
    }

    public function importForm()
    {
        $tryouts = Tryout::orderBy('title')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.import_bank_soal', compact('tryouts', 'categories'));
    }

    public function importBankSoal(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
            'tryout_id' => 'required|exists:tryouts,id',
        ]);

        try {
            // Deklarasikan objek import-nya dulu
            $importData = new \App\Imports\SoalImport($request->tryout_id);
            
            // Eksekusi Import
            \Maatwebsite\Excel\Facades\Excel::import($importData, $request->file('file'));

            // Ambil hasil hitungannya dari class Import
            $sukses = $importData->rowCountSukses;
            $gagal = $importData->rowCountGagal;
            $duplikat = $importData->rowCountDuplikat; 

            // Susun pesan notifikasinya
            if ($gagal > 0 || $duplikat > 0) {
                return back()->with('success', "Proses selesai! $sukses soal baru berhasil diimpor.")
                            ->with('warning', "Perhatian: Ada $duplikat soal duplikat yang ditolak, dan $gagal baris gagal diimpor (karena teks/kategori kosong).");
            }

            return back()->with('success', "Luar biasa! Seluruh $sukses soal berhasil diimpor tanpa ada yang gagal atau duplikat.");
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return back()->withErrors(['file' => 'Format file Excel tidak sesuai standar.']);
        } catch (\Exception $e) {
            // Menangkap error jika file rusak atau sistem down
            return back()->withErrors(['file' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }


    // private function importFromCsv($file, $tryout_id, $category_id, &$errors)
    // {
    //     $imported = 0;
    //     $handle = fopen($file->getRealPath(), 'r');
    //     $header = fgetcsv($handle);
    //     $row = 1;

    //     while (($data = fgetcsv($handle)) !== false) {
    //         $row++;

    //         if (count($data) < 10) {
    //             $errors[] = "Baris $row: Kolom tidak lengkap (diperlukan minimal 10 kolom: pertanyaan, 4 pilihan, 4 poin, pembahasan)";
    //             continue;
    //         }

    //         try {
    //             $category = Category::find($category_id);
    //             $isTkp = $category && strtolower($category->name) === 'tkp';

    //             // Ambil poin pilihan terlebih dahulu dan validasi
    //             $optionPoints = [];
    //             for ($i = 0; $i < 4; $i++) {
    //                 $p = (int)($data[$i + 5] ?? 0);
    //                 $optionPoints[] = $p;
    //             }

    //             if ($isTkp) {
    //                 foreach ($optionPoints as $p) {
    //                     if ($p < 1 || $p > 5) {
    //                         $errors[] = "Baris $row: Untuk kategori TKP, bobot setiap pilihan harus antara 1 dan 5.";
    //                         continue 2;
    //                     }
    //                 }
    //             } else {
    //                 foreach ($optionPoints as $p) {
    //                     if ($p < 0 || $p > 5) {
    //                         $errors[] = "Baris $row: Point setiap pilihan harus antara 0 dan 5.";
    //                         continue 2;
    //                     }
    //                 }
    //             }

    //             $question = Question::create([
    //                 'tryout_id' => $tryout_id,
    //                 'category_id' => $category_id,
    //                 'question_text' => trim($data[0]),
    //                 'discussion' => !empty($data[9]) ? trim($data[9]) : null,
    //             ]);

    //             for ($i = 0; $i < 4; $i++) {
    //                 QuestionOption::create([
    //                     'question_id' => $question->id,
    //                     'option_text' => trim($data[$i + 1]),
    //                     'point' => $optionPoints[$i],
    //                 ]);
    //             }

    //             $imported++;
    //         } catch (\Exception $e) {
    //             $errors[] = "Baris $row: " . $e->getMessage();
    //         }
    //     }

    //     fclose($handle);
    //     return $imported;
    // }

    // private function importFromExcel($file, $tryout_id, $category_id, &$errors)
    // {
    //     $imported = 0;
        
    //     try {
    //         // Simple Excel reading using native PHP
    //         require_once storage_path('app/vendor/autoload.php');
            
    //         // Alternative: read xlsx as zip and parse XML
    //         $zip = new \ZipArchive();
    //         if ($zip->open($file->getRealPath()) === true) {
    //             $xml = $zip->getFromName('xl/worksheets/sheet1.xml');
    //             $zip->close();
                
    //             // Parse XML and extract data
    //             $xmlObject = simplexml_load_string($xml);
                
    //             $row = 0;
    //             foreach ($xmlObject->sheetData->row as $rowElement) {
    //                 $row++;
                    
    //                 if ($row === 1) continue; // Skip header
                    
    //                 $cells = [];
    //                 foreach ($rowElement->c as $cell) {
    //                     $value = (string)$cell->v;
    //                     $cells[] = $value;
    //                 }

    //                 if (count($cells) < 10) {
    //                     $errors[] = "Baris $row: Kolom tidak lengkap (diperlukan minimal 10 kolom: pertanyaan, 4 pilihan, 4 poin, pembahasan)";
    //                     continue;
    //                 }

    //                 try {
    //                     $category = Category::find($category_id);
    //                     $isTkp = $category && strtolower($category->name) === 'tkp';

    //                     // Ambil poin pilihan terlebih dahulu dan validasi
    //                     $optionPoints = [];
    //                     for ($i = 0; $i < 4; $i++) {
    //                         $p = (int)($cells[$i + 5] ?? 0);
    //                         $optionPoints[] = $p;
    //                     }

    //                     if ($isTkp) {
    //                         foreach ($optionPoints as $p) {
    //                             if ($p < 1 || $p > 5) {
    //                                 $errors[] = "Baris $row: Untuk kategori TKP, bobot setiap pilihan harus antara 1 dan 5.";
    //                                 continue 2;
    //                             }
    //                         }
    //                     } else {
    //                         foreach ($optionPoints as $p) {
    //                             if ($p < 0 || $p > 5) {
    //                                 $errors[] = "Baris $row: Point setiap pilihan harus antara 0 dan 5.";
    //                                 continue 2;
    //                             }
    //                         }
    //                     }

    //                     $question = Question::create([
    //                         'tryout_id' => $tryout_id,
    //                         'category_id' => $category_id,
    //                         'question_text' => trim($cells[0]),
    //                         'discussion' => !empty($cells[9]) ? trim($cells[9]) : null,
    //                     ]);

    //                     for ($i = 0; $i < 4; $i++) {
    //                         QuestionOption::create([
    //                             'question_id' => $question->id,
    //                             'option_text' => trim($cells[$i + 1]),
    //                             'point' => $optionPoints[$i],
    //                         ]);
    //                     }

    //                     $imported++;
    //                 } catch (\Exception $e) {
    //                     $errors[] = "Baris $row: " . $e->getMessage();
    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         // Fallback: treat as CSV
    //         return $this->importFromCsv($file, $tryout_id, $category_id, $errors);
    //     }

    //     return $imported;
    // }
}
