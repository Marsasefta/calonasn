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
              <h4>Edit Materi untuk {{ $chapter->title }} ({{ $category->name }})</h4>
              @if($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form method="POST" action="{{ route('admin.learning.material.update', [$category->slug, $chapter->id, $material->id]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label class="form-label">Judul Materi</label>
                  <input type="text" name="title" class="form-control" value="{{ old('title', $material->title) }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Slug</label>
                  <input type="text" name="slug" class="form-control" value="{{ old('slug', $material->slug) }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Konten (HTML)</label>
                  <textarea name="content" id="content" class="form-control" rows="8">{{ old('content', $material->content) }}</textarea>
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" name="is_locked" class="form-check-input" id="is_locked" {{ old('is_locked', $material->is_locked) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_locked">Kunci (Premium)</label>
                </div>
                <div class="mb-3">
                  <label class="form-label">Urutan (angka)</label>
                  <input type="number" name="order_number" class="form-control" value="{{ old('order_number', $material->order_number) ?? 1 }}">
                </div>
                <button class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.learning.category.show', $category->slug) }}" class="btn btn-secondary ms-2">Batal</a>
              </form>
            </div>
          </div>
        </section>
      </main>
    </div>
    @include('partials.scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'imageUpload', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    </script>
  </body>
  </html>
