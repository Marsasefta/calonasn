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

    public function editCategory($slug)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        return view('admin.learning.edit_category', compact('category'));
    }

    public function updateCategory(Request $request, $slug)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:learning_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color_theme' => 'nullable|string|max:100'
        ]);

        $category->update($data);
        return redirect()->route('admin.learning.index')->with('success', 'Kategori materi berhasil diperbarui.');
    }

    public function destroyCategory($slug)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        $category->delete();

        return redirect()->route('admin.learning.index')->with('success', 'Kategori materi berhasil dihapus.');
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

    public function editChapter($slug, $chapterId)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        $chapter = LearningChapter::where('id', $chapterId)->where('learning_category_id', $category->id)->firstOrFail();
        return view('admin.learning.edit_chapter', compact('category', 'chapter'));
    }

    public function updateChapter(Request $request, $slug, $chapterId)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        $chapter = LearningChapter::where('id', $chapterId)->where('learning_category_id', $category->id)->firstOrFail();
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'order_number' => 'nullable|integer'
        ]);
        $chapter->update($data);
        return redirect()->route('admin.learning.category.show', $slug)->with('success', 'Bab berhasil diperbarui');
    }

    public function destroyChapter($slug, $chapterId)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        $chapter = LearningChapter::where('id', $chapterId)->where('learning_category_id', $category->id)->firstOrFail();
        $chapter->delete();
        return redirect()->route('admin.learning.category.show', $slug)->with('success', 'Bab berhasil dihapus');
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

    public function editMaterial($slug, $chapterId, $materialId)
    {
        $category = LearningCategory::where('slug', $slug)->firstOrFail();
        $chapter = LearningChapter::findOrFail($chapterId);
        $material = LearningMaterial::where('id', $materialId)->where('learning_chapter_id', $chapter->id)->firstOrFail();
        return view('admin.learning.edit_material', compact('category', 'chapter', 'material'));
    }

    public function updateMaterial(Request $request, $slug, $chapterId, $materialId)
    {
        $chapter = LearningChapter::findOrFail($chapterId);
        $material = LearningMaterial::where('id', $materialId)->where('learning_chapter_id', $chapter->id)->firstOrFail();
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:learning_materials,slug,' . $material->id,
            'content' => 'nullable|string',
            'order_number' => 'nullable|integer',
            'is_locked' => 'nullable|boolean'
        ]);
        $data['learning_chapter_id'] = $chapter->id;
        $data['is_locked'] = $request->has('is_locked') ? 1 : 0;
        $material->update($data);
        return redirect()->route('admin.learning.category.show', $slug)->with('success','Materi berhasil diperbarui');
    }

    public function destroyMaterial($slug, $chapterId, $materialId)
    {
        $chapter = LearningChapter::findOrFail($chapterId);
        $material = LearningMaterial::where('id', $materialId)->where('learning_chapter_id', $chapter->id)->firstOrFail();
        $material->delete();
        return redirect()->route('admin.learning.category.show', $slug)->with('success','Materi berhasil dihapus');
    }
}
