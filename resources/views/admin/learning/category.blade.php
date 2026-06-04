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
          <div class="row">
            <div class="col-md-3">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                    <div>
                      <h5>{{ $category->name }}</h5>
                      <p class="text-muted mb-0">{{ $category->description }}</p>
                    </div>
                    <!-- <div class="d-flex gap-2">
                      <a href="{{ route('admin.learning.category.edit', $category->slug) }}" class="btn btn-sm btn-secondary">Edit Kategori</a>
                      <form action="{{ route('admin.learning.category.destroy', $category->slug) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Semua bab dan materi terkait juga akan terhapus.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus Kategori</button>
                      </form>
                    </div> -->
                  </div>
                  <a href="{{ route('admin.learning.chapter.create', $category->slug) }}" class="btn btn-sm btn-outline-primary">Tambah Bab</a>
                </div>
              </div>

              <div class="accordion" id="chaptersAccordion">
                @foreach($category->chapters->sortBy('order_number') as $chapter)
                <div class="card mb-2">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <strong>{{ $chapter->title }}</strong>
                        <div class="text-muted small">Urutan: {{ $chapter->order_number }}</div>
                      </div>
                      <div>
                        <a href="{{ route('admin.learning.material.create', [$category->slug, $chapter->id]) }}" class="btn btn-sm btn-primary">Tambah Materi</a>
                      </div>
                    </div>
                    <hr>
                    <ul class="list-unstyled mb-0">
                      @foreach($chapter->materials()->orderBy('order_number')->get() as $m)
                        <li class="mb-2 d-flex justify-content-between align-items-center rounded px-2 py-2" style="background:#f8fafc;">
                          <div>
                            <strong>{{ $m->order_number }}. {{ $m->title }}</strong>
                            @if($m->is_locked)
                              <span class="badge bg-warning text-dark ms-2">Kunci</span>
                            @endif
                          </div>
                          <div class="d-flex gap-1">
                            <a href="{{ route('admin.learning.material.edit', [$category->slug, $chapter->id, $m->id]) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('admin.learning.material.destroy', [$category->slug, $chapter->id, $m->id]) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
                @endforeach
              </div>
            </div>

            <div class="col-md-9">
              <div class="card">
                <div class="card-body">
                  <h4>Konten dan pengaturan</h4>
                  <p class="text-muted">Pilih bab atau materi untuk melihat detail / edit.</p>
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
