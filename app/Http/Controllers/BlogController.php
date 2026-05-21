<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        // Mengarah ke admin.blog (resources/views/admin/blog.blade.php)
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.blog', compact('posts'));
    }

    public function create()
    {
        // Mengarah ke admin.blog_create (resources/views/admin/blog_create.blade.php)
        $categories = BlogCategory::all();
        return view('admin.blog_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt' => 'nullable|max:160',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = Auth::id();
        $data['published_at'] = $request->status === 'published' ? now() : null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('blog-images', 'public');
            $data['image_url'] = Storage::url($path);
        }

        Post::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // 1. Menampilkan Form Edit Artikel beserta data lamanya
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = BlogCategory::all();
        
        return view('admin.blog_edit', compact('post', 'categories'));
    }

    // 2. Memproses Update Perubahan Artikel ke Database
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt' => 'nullable|max:160',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        
        // Buat slug baru jika judulnya diubah oleh user
        $data['slug'] = Str::slug($request->title);
        
        // Atur waktu tayang ulang jika status berubah jadi published
        if ($request->status === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        } elseif ($request->status === 'draft') {
            $data['published_at'] = null;
        }

        // Jika user mengunggah gambar utama baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari server jika ada untuk menghemat kapasitas storage
            if ($post->image_url) {
                $oldPath = str_replace('/storage/', '', $post->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            // Simpan gambar baru
            $file = $request->file('image');
            $path = $file->store('blog-images', 'public');
            $data['image_url'] = Storage::url($path);
        }

        $post->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    // 3. Menghapus Artikel (Soft Delete)
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil dipindahkan ke kotak sampah!');
    }
}