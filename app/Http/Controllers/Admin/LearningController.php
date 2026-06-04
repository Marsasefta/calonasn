<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningCategory;
use App\Models\LearningChapter;
use App\Models\LearningMaterial;

class LearningController extends Controller
{
    public function index()
    {
        $categories = LearningCategory::all();
        return view('admin.learning.lobby', compact('categories'));
    }

    public function showCategory($slug)
    {
        $category = LearningCategory::where('slug', $slug)->with(['chapters' => function($q){ $q->orderBy('order_number'); }])->firstOrFail();
        return view('admin.learning.category', compact('category'));
    }

    public function createCategory()
    {
        return view('admin.learning.create_category');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:learning_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color_theme' => 'nullable|string|max:100'
        ]);

        LearningCategory::create($data);
        return redirect()->route('admin.learning.index')->with('success', 'Kategori materi berhasil disimpan.');
    }

    public function createChapter($slug)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        return view('admin.learning.create_chapter', compact('category'));
    }

    public function storeChapter(Request $request, $slug)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'order_number' => 'nullable|integer'
        ]);
        $data['learning_category_id'] = $category->id;
        LearningChapter::create($data);
        return redirect()->route('admin.learning.category.show', $category->slug)->with('success','Bab berhasil ditambahkan');
    }

    public function createMaterial($slug, $chapterId)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        $chapter = LearningChapter::findOrFail($chapterId);
        return view('admin.learning.create_material', compact('category','chapter'));
    }

    public function storeMaterial(Request $request, $slug, $chapterId)
    {
        $chapter = LearningChapter::findOrFail($chapterId);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:learning_materials,slug',
            'content' => 'nullable|string',
            'order_number' => 'nullable|integer',
            'is_locked' => 'nullable|boolean'
        ]);
        $data['learning_chapter_id'] = $chapter->id;
        $data['is_locked'] = $request->has('is_locked') ? 1 : 0;
        LearningMaterial::create($data);
        return redirect()->route('admin.learning.category.show', $slug)->with('success','Materi berhasil ditambahkan');
    }
}
