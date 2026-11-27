<!doctype html>
<html lang="en">
  <head>
    @include('partials.head')
  </head>
  <body>
    <div id="db-wrapper">
      @include('partials.navbar-vertical')
      <main id="page-content">
        @include('partials.dashboard-header')
        <section class="container-fluid p-4">
          <div class="card">
            <div class="card-body">
              <h4>Tambah Materi untuk {{ $chapter->title }} ({{ $category->name }})</h4>
              @if($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form method="POST" action="{{ route('admin.learning.material.store', [$category->slug, $chapter->id]) }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Judul Materi</label>
                  <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Slug</label>
                  <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Konten (HTML)</label>
                  <textarea name="content" id="content" class="form-control" rows="8">{{ old('content') }}</textarea>
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" name="is_locked" value="1" class="form-check-input" id="is_locked" {{ old('is_locked') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_locked">Kunci (Premium)</label>
                </div>
                <div class="mb-3">
                  <label class="form-label">Urutan (angka)</label>
                  <input type="number" name="order_number" class="form-control" value="{{ old('order_number', 1) }}">
                </div>
                <button class="btn btn-primary">Simpan Materi</button>
                <a href="{{ route('admin.learning.category.show', $category->slug) }}" class="btn btn-secondary ms-2">Batal</a>
              </form>
            </div>
          </div>
        </section>
      </main>
    </div>
    @include('partials.scripts')
    @include('admin.learning.partials.ckeditor')
  </body>
  </html>
