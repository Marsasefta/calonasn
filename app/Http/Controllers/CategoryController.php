<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'passing_grade_score' => 'nullable|integer|min:0',
        ]);

        Category::create([
            'name' => $validated['name'],
            'passing_grade_score' => $validated['passing_grade_score'] ?? 0,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil disimpan.');
    }
}
