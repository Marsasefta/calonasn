<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Tryout;
use Illuminate\Http\Request;

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
}
