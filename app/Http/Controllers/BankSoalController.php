<?php

namespace App\Http\Controllers;

use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // 1. Validasi Input
        $validated = $request->validate([
            'tryout_id'      => 'required|exists:tryouts,id',
            'category_id'    => 'required|exists:categories,id',
            
            // UBAH: question_text jadi nullable agar bisa soal murni gambar
            'question_text'  => 'nullable|string', 
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            'discussion'     => 'nullable|string',
            
            // Validasi Opsi (Teks nullable, point tetap required)
            'option_a' => 'nullable|string', 'image_a' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_a' => 'required|integer|min:0|max:5',
            'option_b' => 'nullable|string', 'image_b' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_b' => 'required|integer|min:0|max:5',
            'option_c' => 'nullable|string', 'image_c' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_c' => 'required|integer|min:0|max:5',
            'option_d' => 'nullable|string', 'image_d' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_d' => 'required|integer|min:0|max:5',
            'option_e' => 'nullable|string', 'image_e' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_e' => 'required|integer|min:0|max:5',
        ]);

        // 2. Proses Upload Gambar Soal Utama (Jika ada)
        $questionImagePath = null;
        if ($request->hasFile('question_image')) {
            $questionImagePath = $request->file('question_image')->store('soal_images', 'public');
        }

        // 3. Simpan Soal ke Database
        $question = Question::create([
            'tryout_id'      => $validated['tryout_id'],
            'category_id'    => $validated['category_id'],
            // PERBAIKAN: Gunakan ?? '' agar jika null, tersimpan sebagai string kosong
            'question_text'  => $validated['question_text'] ?? '', 
            'question_image' => $questionImagePath,
            'discussion'     => $validated['discussion'] ?? null,
        ]);

        // 4. Simpan Opsi Jawaban menggunakan Looping
        $options = ['a', 'b', 'c', 'd', 'e'];

        foreach ($options as $opt) {
            $optionImagePath = null;

            // Proses Upload Gambar Opsi (Jika ada)
            if ($request->hasFile("image_{$opt}")) {
                $optionImagePath = $request->file("image_{$opt}")->store('opsi_images', 'public');
            }

            // Simpan ke tabel QuestionOption
            QuestionOption::create([
                'question_id'  => $question->id,
                // PERBAIKAN: Gunakan ?? '' agar tidak error NOT NULL di database
                'option_text'  => $validated["option_{$opt}"] ?? '', 
                'option_image' => $optionImagePath,
                'point'        => $validated["point_{$opt}"],
            ]);
        }

        return back()->with('success', 'Bank soal beserta gambar berhasil disimpan.');
    }

    public function listBankSoal()
    {
        $tryouts = Tryout::orderBy('title')->get();

        // TAMBAHKAN withCount('questions') DI SINI
        $categories = Category::withCount('questions')->orderBy('name')->get();

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
        // 1. Validasi Input
        $validated = $request->validate([
            'tryout_id'      => 'required|exists:tryouts,id',
            'category_id'    => 'required|exists:categories,id',
            'question_text'  => 'nullable|string',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'discussion'     => 'nullable|string',
            
            // Teks dibuat nullable, point wajib
            'option_a' => 'nullable|string', 'image_a' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_a' => 'required|integer|min:0|max:5',
            'option_b' => 'nullable|string', 'image_b' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_b' => 'required|integer|min:0|max:5',
            'option_c' => 'nullable|string', 'image_c' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_c' => 'required|integer|min:0|max:5',
            'option_d' => 'nullable|string', 'image_d' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_d' => 'required|integer|min:0|max:5',
            'option_e' => 'nullable|string', 'image_e' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 'point_e' => 'required|integer|min:0|max:5',
        ]);

        $question = Question::findOrFail($id);

        // 2. Cek & Update Gambar Soal Utama
        $questionImagePath = $question->question_image; // Bawaan path lama

        if ($request->hasFile('question_image')) {
            // Jika ada gambar baru, hapus gambar lama dari storage biar nggak nyampah
            if ($question->question_image) {
                Storage::disk('public')->delete($question->question_image);
            }
            // Simpan gambar baru
            $questionImagePath = $request->file('question_image')->store('soal_images', 'public');
        }

        // 3. Update Soal di Database
        $question->update([
            'tryout_id'      => $validated['tryout_id'],
            'category_id'    => $validated['category_id'],
            'question_text'  => $validated['question_text'] ?? '',
            'question_image' => $questionImagePath,
            'discussion'     => $validated['discussion'] ?? null,
        ]);

        // 4. Update Opsi Jawaban
        $options = $question->options()->orderBy('id')->get();
        $optionLetters = ['a', 'b', 'c', 'd', 'e'];
        
        foreach ($optionLetters as $index => $letter) {
            $option = $options[$index] ?? null;
            $optionImagePath = $option ? $option->option_image : null; // Path lama

            // Cek jika ada upload gambar baru untuk opsi ini
            if ($request->hasFile("image_{$letter}")) {
                // Hapus gambar lama jika ada
                if ($option && $option->option_image) {
                    Storage::disk('public')->delete($option->option_image);
                }
                // Simpan gambar baru
                $optionImagePath = $request->file("image_{$letter}")->store('opsi_images', 'public');
            }

            // Update jika opsi sudah ada, Create jika belum ada
            if ($option) {
                $option->update([
                    'option_text'  => $validated['option_' . $letter] ?? '',
                    'option_image' => $optionImagePath,
                    'point'        => $validated['point_' . $letter],
                ]);
            } else {
                QuestionOption::create([
                    'question_id'  => $question->id,
                    'option_text'  => $validated['option_' . $letter] ?? '',
                    'option_image' => $optionImagePath,
                    'point'        => $validated['point_' . $letter],
                ]);
            }
        }

        return redirect()->route('admin.list-bank-soal')->with('success', 'Bank soal beserta gambar berhasil diperbarui.');
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
}
