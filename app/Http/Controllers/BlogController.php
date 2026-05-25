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
    // Menampilkan daftar artikel untuk pengunjung (calonasn.id/blog)
    public function index()
    {
        // Hanya tampilkan yang berstatus 'published'
        $posts = Post::with(['category', 'author'])
                    ->where('status', 'published')
                    ->latest()
                    ->paginate(9); // 9 agar pas kalau pakai grid 3 kolom

        // Mengarah ke view publik (misal: resources/views/blog_index.blade.php)
        return view('blog_index', compact('posts'));
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

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Tambahkan 'slug' ke dalam aturan validasi
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|string|max:255', // Validasi slug baru
            'content' => 'required',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt' => 'nullable|max:160',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        
        // LOGIKA SLUG BARU:
        // Cek apakah user mengisi kolom slug di form
        if ($request->filled('slug')) {
            // Jika diisi, gunakan isian user dan pastikan formatnya benar (pakai strip)
            $data['slug'] = Str::slug($request->slug);
        } else {
            // Jika dibiarkan kosong, otomatis buat dari judul artikel
            $data['slug'] = Str::slug($request->title);
        }
        
        // Atur waktu tayang ulang jika status berubah jadi published
        if ($request->status === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        } elseif ($request->status === 'draft') {
            $data['published_at'] = null;
        }

        // Jika user mengunggah gambar utama baru
        if ($request->hasFile('image')) {
            if ($post->image_url) {
                $oldPath = str_replace('/storage/', '', $post->image_url);
                Storage::disk('public')->delete($oldPath);
            }

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
    
    // Menampilkan preview detail artikel khusus di dalam dashboard Admin
    public function showAdmin($id)
    {
        // Menggunakan findOrFail agar jika ID tidak ada langsung memicu error 404
        $post = Post::with(['category', 'author'])->findOrFail($id);
        
        return view('admin.blog_show', compact('post'));
    }

    // Menampilkan detail artikel untuk pembaca umum (sebelum login)
    public function show($slug)
    {
        $post = \App\Models\Post::with(['category', 'author'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail(); 

        $relatedPosts = \App\Models\Post::where('status', 'published')
                            ->where('id', '!=', $post->id)
                            ->latest()
                            ->take(3)
                            ->get();

        // Mengarah ke view baca artikel (resources/views/blog_show.blade.php)
        return view('blog_show', compact('post', 'relatedPosts'));
    }

    // 0. Menampilkan tabel daftar artikel di Dashboard Admin
    public function adminIndex()
    {
        // Tampilkan semua artikel (termasuk draft) untuk dikelola admin
        $posts = Post::with('category')->latest()->paginate(10);
        
        // Mengarah ke admin.blog (resources/views/admin/blog.blade.php)
        return view('admin.blog', compact('posts'));
    }
}