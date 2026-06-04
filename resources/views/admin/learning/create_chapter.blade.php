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
              <h4>Tambah Bab untuk {{ $category->name }}</h4>
              <form method="POST" action="{{ route('admin.learning.chapter.store', $category->slug) }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Judul Bab</label>
                  <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Urutan (angka)</label>
                  <input type="number" name="order_number" class="form-control" value="1">
                </div>
                <button class="btn btn-primary">Simpan</button>
              </form>
            </div>
          </div>
        </section>
      </main>
    </div>
    @include('partials.scripts')
  </body>
  </html>
