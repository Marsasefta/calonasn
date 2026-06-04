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
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4">Materi Pembelajaran - Lobby</h2>
            <a href="{{ route('admin.learning.create') }}" class="btn btn-primary">Tambah Kategori</a>
          </div>

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <div class="row">
            @foreach($categories as $cat)
            <div class="col-md-4 mb-3">
              <div class="card shadow-sm h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="icon-wrapper" style="width:56px;height:56px;border-radius:10px;background:#f3f4f6;display:flex;align-items:center;justify-content:center">
                      <i class="{{ $cat->icon ?? 'fe fe-book' }}"></i>
                    </div>
                    <div>
                      <h5 class="mb-0">{{ $cat->name }}</h5>
                      <small class="text-muted">{{ $cat->description }}</small>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between gap-2">
                    <a href="{{ route('admin.learning.category.show', $cat->slug) }}" class="btn btn-sm btn-outline-primary flex-grow-1">Lihat</a>
                    <a href="{{ route('admin.learning.category.edit', $cat->slug) }}" class="btn btn-sm btn-secondary flex-grow-1">Edit</a>
                    <form action="{{ route('admin.learning.category.destroy', $cat->slug) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Hapus kategori ini? Semua bab dan materi terkait juga akan terhapus.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger w-100">Hapus</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </section>
      </main>
    </div>
    @include('partials.scripts')
  </body>
  </html>
