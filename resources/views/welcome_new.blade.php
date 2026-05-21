@extends('layouts.landing')

@push('styles')
    <style>
      :root {
        --color-primary: #1e40af;
        --color-secondary: #3b82f6;
        --color-accent: #06b6d4;
        --color-success: #10b981;
        --color-light: #f8fafc;
        --color-light-blue: #e0f2fe;
        --color-gradient-start: #1e40af;
        --color-gradient-end: #3b82f6;
        --color-text-dark: #1e293b;
        --color-text-muted: #64748b;
        --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
      }

      body {
        background-color: #ffffff;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      }

      .hero-section {
        background: linear-gradient(135deg, var(--color-light-blue) 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
      }

      .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23e0f2fe" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23e0f2fe" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%233b82f6" opacity="0.05"/><circle cx="10" cy="50" r="0.5" fill="%233b82f6" opacity="0.05"/><circle cx="90" cy="30" r="0.5" fill="%233b82f6" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
      }

      .hero-title {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: fadeInUp 1s ease-out;
      }

      .hero-subtitle {
        color: var(--color-text-muted);
        animation: fadeInUp 1.2s ease-out;
      }

      .hero-buttons {
        animation: fadeInUp 1.4s ease-out;
      }

      .hero-image {
        animation: slideInRight 1.6s ease-out;
        position: relative;
      }

      .hero-image::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
        border-radius: 50%;
        opacity: 0.1;
        z-index: -1;
        animation: pulse 3s infinite;
      }

      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes slideInRight {
        from {
          opacity: 0;
          transform: translateX(50px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }

      @keyframes pulse {
        0%, 100% {
          transform: scale(1);
        }
        50% {
          transform: scale(1.05);
        }
      }

      /* Tambahkan ini di bagian paling bawah dalam block <style> kamu */
      .blog-card {
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 16px;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
      }

      .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-large);
      }

      .blog-image-wrapper {
        position: relative;
        overflow: hidden;
        padding-top: 56.25%; /* Rasio 16:9 */
      }

      .blog-image-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
      }

      .blog-card:hover .blog-image-wrapper img {
        transform: scale(1.05);
      }

      .blog-category-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: rgba(255, 255, 255, 0.95);
        color: var(--color-primary);
        font-weight: 600;
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 20px;
        box-shadow: var(--shadow-light);
        backdrop-filter: blur(4px);
      }

      .blog-title-link {
        color: var(--color-text-dark);
        text-decoration: none;
        transition: color 0.2s ease;
      }

      .blog-title-link:hover {
        color: var(--color-secondary);
      }

      .blog-excerpt {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, var(--color-light) 100%);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 16px;
        padding: 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
      }

      .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
        transition: width 0.3s ease;
      }

      .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-large);
      }

      .stat-card:hover::before {
        width: 100%;
      }

      .stat-number {
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
      }

      .feature-card {
        background: #ffffff;
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
      }

      .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
      }

      .feature-card:hover {
        transform: translateY(-12px);
        box-shadow: var(--shadow-large);
      }

      .feature-card:hover::before {
        transform: scaleX(1);
      }

      .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--color-light-blue) 0%, rgba(59, 130, 246, 0.1) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        transition: all 0.3s ease;
      }

      .feature-card:hover .feature-icon {
        transform: scale(1.1);
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
        color: white;
      }

      .btn-primary {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 32px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
      }

      .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
      }

      .btn-primary:hover::before {
        left: 100%;
      }

      .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
      }

      .btn-outline-primary {
        border: 2px solid var(--color-primary);
        color: var(--color-primary);
        border-radius: 12px;
        padding: 12px 32px;
        font-weight: 600;
        transition: all 0.3s ease;
      }

      .btn-outline-primary:hover {
        background: var(--color-primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
      }

      .cta-section {
        background: linear-gradient(135deg, var(--color-gradient-start) 0%, var(--color-gradient-end) 100%);
        border-radius: 24px;
        padding: 4rem 2rem;
        margin: 4rem 0;
        position: relative;
        overflow: hidden;
      }

      .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="60" cy="30" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="70" r="0.5" fill="rgba(255,255,255,0.1)"/></svg>');
        animation: float 20s infinite linear;
      }

      @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(-20px, -20px) rotate(360deg); }
      }

      .section-title {
        color: var(--color-text-dark);
        font-weight: 700;
        margin-bottom: 1rem;
      }

      .section-subtitle {
        color: var(--color-text-muted);
        font-size: 1.125rem;
        line-height: 1.75;
      }

      @media (max-width: 768px) {
        .hero-title {
          font-size: 2.5rem;
        }

        .stat-card, .feature-card {
          margin-bottom: 1rem;
        }
      }
    </style>
@endpush

@section('content')
<main>
  <!--Hero Section-->
  <section class="hero-section py-8">
    <div class="container">
      <div class="row align-items-center gy-5">
        <div class="col-lg-7 col-12">
          <div class="d-flex flex-column gap-4">
            <div class="d-flex flex-column gap-3">
              <h1 class="hero-title mb-0 display-3 fw-bold lh-1">Raih Kesempatan Emas Menjadi PNS</h1>
              <p class="hero-subtitle mb-0 fs-5">Platform terdepan untuk persiapan ujian SKD CPNS & PPPK dengan materi komprehensif,dan ribuan soal latihan. Raih kesempatan emas menjadi Aparatur Sipil Negara yang profesional dan berkompeten.</p>
            </div>
            <div class="hero-buttons d-flex flex-row gap-3 flex-wrap">
              <a href="#!" class="btn btn-primary btn-lg">
                <i class="fas fa-rocket me-2"></i>Mulai Perjalanan Sukses
              </a>
              <a href="#!" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-play-circle me-2"></i>Lihat Demo
              </a>
            </div>
            <div class="d-flex align-items-center gap-4 mt-3">
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-star text-warning"></i>
                <span class="fw-semibold">4.9/5 Rating</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-users text-primary"></i>
                <span class="fw-semibold">50,000+ Peserta</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-certificate text-success"></i>
                <span class="fw-semibold">95% Kelulusan</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-12 d-none d-lg-block">
          <div class="hero-image text-center position-relative">
            <img src="/build/assets/images/course/woman-hero.png" alt="Professional working on career development" class="img-fluid" style="max-width: 85%; border-radius: 16px; box-shadow: var(--shadow-large);" />
            <div class="position-absolute" style="bottom: 20px; left: 20px; background: white; padding: 16px; border-radius: 12px; box-shadow: var(--shadow-medium);">
              <div class="d-flex align-items-center gap-2">
                <div style="width: 12px; height: 12px; background: var(--color-success); border-radius: 50%;"></div>
                <span class="fw-semibold text-dark">95% Success Rate</span>
              </div>
            </div>
            <div class="position-absolute" style="top: 20px; right: 20px; background: white; padding: 12px; border-radius: 12px; box-shadow: var(--shadow-medium);">
              <i class="fas fa-graduation-cap text-primary fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="py-8">
    <div class="container">
      <div class="row gy-4">
        <div class="col-md-4 col-12">
          <div class="stat-card text-center">
            <div class="mb-3">
              <i class="fas fa-users fa-3x text-primary"></i>
            </div>
            <h3 class="stat-number mb-2 display-5 fw-bold">50,000+</h3>
            <p class="mb-0 text-muted fw-semibold">Peserta Aktif</p>
            <small class="text-muted">Bergabung setiap bulan</small>
          </div>
        </div>
        <div class="col-md-4 col-12">
          <div class="stat-card text-center">
            <div class="mb-3">
              <i class="fas fa-brain fa-3x text-primary"></i>
            </div>
            <h3 class="stat-number mb-2 display-5 fw-bold">10,000+</h3>
            <p class="mb-0 text-muted fw-semibold">Soal Latihan</p>
            <small class="text-muted">Dengan pembahasan lengkap</small>
          </div>
        </div>
        <div class="col-md-4 col-12">
          <div class="stat-card text-center">
            <div class="mb-3">
              <i class="fas fa-trophy fa-3x text-primary"></i>
            </div>
            <h3 class="stat-number mb-2 display-5 fw-bold">95%</h3>
            <p class="mb-0 text-muted fw-semibold">Tingkat Kelulusan</p>
            <small class="text-muted">Rate kesuksesan tinggi</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-8">
    <div class="container">
      <div class="row align-items-end mb-5">
        <div class="col-md-8 col-12 text-center text-md-start">
          <h2 class="section-title h1 mb-2">Artikel & Kabar Terbaru</h2>
          <p class="section-subtitle mb-0 text-muted">Ikuti tips sukses, info regulasi CPNS, dan materi pembelajaran terupdate langsung dari ahlinya.</p>
        </div>
        <div class="col-md-4 col-12 text-center text-md-end d-none d-md-block">
          <a href="#!" class="btn btn-outline-primary">Lihat Semua Artikel <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
      </div>

      <div class="row gy-4">
        @forelse($latestPosts as $post)
          <div class="col-lg-4 col-md-6 col-12">
            <article class="blog-card h-100 card border-0 shadow-sm">
              <div class="blog-image-wrapper">
                <img src="{{ $post->image_url ?? '/build/assets/images/course/default-blog.png' }}" alt="{{ $post->title }}">
                <span class="blog-category-badge">{{ $post->category->name }}</span>
              </div>
              
              <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                  <div class="d-flex align-items-center gap-2 mb-2 text-muted fs-7">
                    <span><i class="far fa-calendar-alt me-1"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                    <span>•</span>
                    <span><i class="far fa-user me-1"></i> {{ $post->author->name ?? 'Admin' }}</span>
                  </div>
                  <h4 class="card-title fw-bold lh-base mb-2">
                    <a href="#!" class="blog-title-link">{{ $post->title }}</a>
                  </h4>
                  <p class="card-text text-muted blog-excerpt fs-6 mb-4">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 90) }}
                  </p>
                </div>
                
                <div class="pt-3 border-top mt-auto">
                  <a href="#!" class="text-primary fw-bold text-decoration-none d-flex align-items-center gap-1 fs-6">
                    Baca Selengkapnya <i class="fas fa-chevron-right fs-7 transition-transform"></i>
                  </a>
                </div>
              </div>
            </article>
          </div>
        @empty
          <div class="col-12 text-center py-5">
            <div class="text-muted p-4">
              <i class="far fa-newspaper fa-3x mb-3 text-secondary opacity-50"></i>
              <p class="mb-0 fw-medium">Belum ada artikel yang diterbitkan.</p>
            </div>
          </div>
        @endforelse
      </div>

      <div class="row d-md-none mt-4">
        <div class="col-12 text-center">
          <a href="#!" class="btn btn-outline-primary w-100">Lihat Semua Artikel</a>
        </div>
      </div>
    </div>
  </section>

  <!--Why Choose Us Section--> 
  <section class="py-8" style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);">
    <div class="container">
      <div class="row mb-7">
        <div class="col-lg-8 col-md-10 col-12 mx-auto">
          <div class="text-center">
            <h2 class="section-title h1 mb-3">Mengapa CalonASN.id?</h2>
            <p class="section-subtitle mb-0">Platform terpercaya dengan dukungan komprehensif untuk kesuksesan karir Anda di dunia birokrasi.</p>
          </div>
        </div>
      </div>
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="feature-card card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
              <div class="feature-icon">
                <i class="fas fa-book-open fa-2x text-primary"></i>
              </div>
              <h5 class="card-title fw-bold mb-3">Materi Lengkap & Terkini</h5>
              <p class="card-text text-muted">Materi pembelajaran disusun oleh ahli dan selalu diperbarui sesuai dengan perubahan peraturan terbaru. Akses materi kapan saja dan di mana saja.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="feature-card card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
              <div class="feature-icon">
                <i class="fas fa-laptop-code fa-2x text-primary"></i>
              </div>
              <h5 class="card-title fw-bold mb-3">Praktik Soal Interaktif</h5>
              <p class="card-text text-muted">Ribuan soal latihan dengan pembahasan detail dan simulasi ujian sesungguhnya. Tingkatkan kemampuan dengan latihan terstruktur.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="feature-card card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
              <div class="feature-icon">
                <i class="fas fa-chart-line fa-2x text-primary"></i>
              </div>
              <h5 class="card-title fw-bold mb-3">Analitik & Progress Tracking</h5>
              <p class="card-text text-muted">Pantau perkembangan belajar Anda dengan dashboard analitik yang komprehensif dan rekomendasi personal untuk peningkatan performa.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--CTA Section-->
  <section class="py-8">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-12 mx-auto">
          <div class="btn btn-primary rounded-4 p-6 text-white text-center">
            <h2 class="mb-3 text-white">Siap Memulai Persiapan Ujian PNS?</h2>
            <p class="mb-4 fs-5">Bergabunglah dengan ribuan peserta yang telah berhasil lulus ujian SKD CPNS & PPPK bersama platform kami.</p>
            <a href="#!" class="btn btn-light btn-lg">Daftar Gratis Sekarang</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@push('scripts')
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
@endpush
