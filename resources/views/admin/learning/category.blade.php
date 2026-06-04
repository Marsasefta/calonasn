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
                  <h5>{{ $category->name }}</h5>
                  <p class="text-muted">{{ $category->description }}</p>
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
                        <li class="mb-1">{{ $m->order_number }}. {{ $m->title }} @if($m->is_locked) <span class="badge bg-warning text-dark">Kunci</span> @endif</li>
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
