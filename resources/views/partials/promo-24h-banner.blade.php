@php
    $promo24h = $promo24h ?? (auth()->check() ? auth()->user()->newMemberPromo() : null);
    $showCta = $showCta ?? true;
    $compact = $compact ?? false;
@endphp

@if ($promo24h)
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden promo-24h-banner"
         data-remaining-seconds="{{ $promo24h['remaining_seconds'] }}"
         style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 55%, #fde68a 100%); border: 1.5px solid #f59e0b !important;">
        <div class="card-body {{ $compact ? 'p-3' : 'p-3 p-md-4' }}">
            <div class="row align-items-center g-3">
                <div class="{{ $showCta ? 'col-lg-8' : 'col-lg-9' }}">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <span class="badge bg-danger text-white rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem;">
                            🔥 PROMO PENDAFTAR BARU
                        </span>
                        <span class="badge bg-white text-dark border border-warning rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem;">
                            Kode: <span class="text-primary font-monospace">{{ $promo24h['code'] }}</span>
                        </span>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">
                        Diskon Rp {{ number_format($promo24h['discount_amount'], 0, ',', '.') }} Berakhir {{ $promo24h['deadline_label'] ?? 'Pukul 23:59 WIB' }}!
                    </h5>
                    <p class="text-dark text-opacity-75 small mb-0">
                        Tryout Mandiri jadi <strong class="text-dark">Rp 13.000</strong> <span class="text-decoration-line-through text-muted">Rp 20.000</span>
                        • Paket Super Lengkap (Unlimited + Full Materi) jadi <strong class="text-primary">Rp 42.000</strong> <span class="text-decoration-line-through text-muted">Rp 49.000</span>
                    </p>
                </div>

                <div class="{{ $showCta ? 'col-lg-4' : 'col-lg-3' }} text-lg-end">
                    <div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                        <div class="bg-dark text-white rounded-3 px-3 py-2 text-center shadow-xs">
                            <span class="d-block text-warning fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px;">SISA WAKTU PROMO</span>
                            <span class="font-monospace fw-bolder fs-5 promo-24h-timer" style="letter-spacing: 1px;">--:--:--</span>
                        </div>
                        @if ($showCta)
                            <a href="{{ route('user.pilih-paket') }}" class="btn btn-danger fw-bold rounded-pill px-4 py-2.5 shadow-sm text-nowrap">
                                Klaim Diskon <i class="fe fe-arrow-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @once
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.promo-24h-banner').forEach(function (banner) {
                    let remaining = parseInt(banner.getAttribute('data-remaining-seconds') || '0', 10);
                    const timerEl = banner.querySelector('.promo-24h-timer');

                    function renderCountdown() {
                        if (remaining <= 0) {
                            banner.style.display = 'none';
                            return false;
                        }
                        const h = String(Math.floor(remaining / 3600)).padStart(2, '0');
                        const m = String(Math.floor((remaining % 3600) / 60)).padStart(2, '0');
                        const s = String(remaining % 60).padStart(2, '0');
                        if (timerEl) {
                            timerEl.textContent = h + ':' + m + ':' + s;
                        }
                        return true;
                    }

                    if (!renderCountdown()) return;

                    const intervalId = setInterval(function () {
                        remaining--;
                        if (!renderCountdown()) {
                            clearInterval(intervalId);
                        }
                    }, 1000);
                });
            });
        </script>
    @endonce
@endif
