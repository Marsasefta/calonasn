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
              <form method="POST" action="{{ route('admin.learning.material.store', [$category->slug, $chapter->id]) }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Judul Materi</label>
                  <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Slug</label>
                  <input type="text" name="slug" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Konten (HTML)</label>
                  <textarea name="content" class="form-control" rows="8"></textarea>
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" name="is_locked" class="form-check-input" id="is_locked">
                  <label class="form-check-label" for="is_locked">Kunci (Premium)</label>
                </div>
                <div class="mb-3">
                  <label class="form-label">Urutan (angka)</label>
                  <input type="number" name="order_number" class="form-control" value="1">
                </div>
                <button class="btn btn-primary">Simpan Materi</button>
              </form>
            </div>
          </div>
        </section>
      </main>
    </div>
    @include('partials.scripts')
  </body>
  </html>
