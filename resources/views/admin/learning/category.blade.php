<!doctype html>
<html lang="en">
  <head>
    @include('partials.head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
      .material-item {
        transition: all 0.2s ease-in-out;
        border: 1px solid transparent;
      }
      .material-item:hover {
        background-color: #f1f5f9 !important;
        border-color: #cbd5e1;
        transform: translateX(4px);
      }
      .chapter-card {
        border-left: 4px solid #0d6efd; /* Memberikan aksen warna utama pada bab */
      }
    </style>
  </head>
  <body>
    <div id="db-wrapper">
      @include('partials.navbar-vertical')
      <main id="page-content">
        @include('partials.dashboard-header')

        <section class="container-fluid p-4">
          <div class="row g-4">
            
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                  <div class="d-flex flex-sm-row flex-column justify-content-between align-items-sm-center align-items-start gap-3">
                    <div>
                      <span class="badge bg-primary-subtle text-primary mb-2">Kategori</span>
                      <h4 class="fw-bold text-dark mb-1">{{ $category->name }}</h4>
                      <p class="text-muted small mb-0">{{ $category->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                    <div class="flex-shrink-0">
                      <a href="{{ route('admin.learning.chapter.create', $category->slug) }}" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle"></i> Tambah Bab Baru
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion" id="chaptersAccordion">
                @forelse($category->chapters->sortBy('order_number') as $chapter)
                <div class="card shadow-sm border-0 mb-3 chapter-card">
                  <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <div>
                        <span class="text-muted small fw-semibold tracking-wide text-uppercase">Bab {{ $chapter->order_number }}</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1">{{ $chapter->title }}</h5>
                      </div>
                      <div class="d-flex gap-2">
                        <a href="{{ route('admin.learning.material.create', [$category->slug, $chapter->id]) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" title="Tambah Materi">
                          <i class="bi bi-file-earmark-plus"></i> <span>Tambah Materi</span>
                        </a>
                        <a href="{{ route('admin.learning.chapter.edit', [$category->slug, $chapter->id]) }}" class="btn btn-sm btn-white border shadow-sm text-secondary px-2" title="Edit Bab">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.learning.chapter.destroy', [$category->slug, $chapter->id]) }}" method="POST" onsubmit="return confirm('Hapus bab ini? Semua materi di dalamnya juga akan dihapus.');" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-white border shadow-sm text-danger px-2" title="Hapus Bab">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </div>
                    </div>

                    <div class="pt-2 border-top">
                      @php $materials = $chapter->materials()->orderBy('order_number')->get(); @endphp
                      
                      @if($materials->isEmpty())
                        <div class="text-center py-3">
                          <p class="text-muted small mb-0">Belum ada materi di bab ini.</p>
                        </div>
                      @else
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                          @foreach($materials as $m)
                            <li class="material-item d-flex justify-content-between align-items-center rounded-3 p-3" style="background: #f8fafc;">
                              <div class="d-flex align-items-center gap-2 overflow-hidden">
                                <span class="fw-semibold text-secondary flex-shrink-0">{{ $m->order_number }}.</span>
                                <span class="text-dark text-truncate fw-medium small">{{ $m->title }}</span>
                                @if($m->is_locked)
                                  <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle d-flex align-items-center gap-1 flex-shrink-0 py-1 px-2" style="font-size: 0.7rem;">
                                    <i class="bi bi-lock-fill"></i> Kunci
                                  </span>
                                @endif
                              </div>
                              
                              <div class="d-flex gap-1 flex-shrink-0 ms-2">
                                <a href="{{ route('admin.learning.material.edit', [$category->slug, $chapter->id, $m->id]) }}" class="btn btn-sm btn-white border shadow-sm text-secondary px-2" title="Edit Materi">
                                  <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.learning.material.destroy', [$category->slug, $chapter->id, $m->id]) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');" class="d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-white border shadow-sm text-danger px-2" title="Hapus Materi">
                                    <i class="bi bi-trash"></i>
                                  </button>
                                </form>
                              </div>
                            </li>
                          @endforeach
                        </ul>
                      @endif
                    </div>

                  </div>
                </div>
                @empty
                <div class="card shadow-sm border-0">
                  <div class="card-body text-center p-5">
                    <i class="bi bi-folder-x text-muted" style="font-size: 2.5rem;"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada bab yang dibuat untuk kategori ini.</p>
                  </div>
                </div>
                @endforelse
              </div>
            </div>

            <div class="col-xl-4 col-lg-5">
              <div class="card shadow-sm border-0 bg-white" style="min-height: 300px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4 text-center">
                  <div class="mb-3 bg-light p-3 rounded-circle text-primary">
                    <i class="bi bi-file-earmark-richtext" style="font-size: 2rem;"></i>
                  </div>
                  <h5 class="fw-bold text-dark">Konten dan Pengaturan</h5>
                  <p class="text-muted small mb-0">Silakan pilih salah satu bab atau materi di panel sebelah kiri untuk memuat detail data atau konfigurasi lanjutan.</p>
                </div>
              </div>
            </div>

          </div>
        </section>
      </main>
    </div>
    @include('partials.scripts')
  </body>
</html>