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
              <h4>Edit Kategori Materi Pembelajaran</h4>
              @if($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form method="POST" action="{{ route('admin.learning.category.update', $category->slug) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label class="form-label">Nama Kategori</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Slug</label>
                  <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}" required>
                  <small class="text-muted">Contoh: twk, tiu, tkp</small>
                </div>
                <div class="mb-3">
                  <label class="form-label">Deskripsi Singkat</label>
                  <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label">Icon</label>
                  <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon) }}" placeholder="fe fe-book">
                </div>
                <div class="mb-3">
                  <label class="form-label">Tema Warna</label>
                  <input type="text" name="color_theme" class="form-control" value="{{ old('color_theme', $category->color_theme) }}" placeholder="primary, success, danger">
                </div>
                <button class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.learning.index') }}" class="btn btn-secondary ms-2">Batal</a>
              </form>
            </div>
          </div>
        </section>
      </main>
    </div>
    @include('partials.scripts')
  </body>
</html>
