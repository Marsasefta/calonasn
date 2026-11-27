@php
    $promo24h = $promo24h ?? (auth()->check() ? auth()->user()->newMemberPromo() : null);
    $showCta = $showCta ?? true;
    $compact = $compact ?? false;
@endphp

@if ($promo24h)
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden promo-24h-banner"
         data-remaining-seconds="{{ $promo24h['remaining_seconds'] }}"
         style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 55%, #fde68a 100%) !important; border: 1.5px solid #f59e0b !important; color: #1e293b !important;">
        <div class="card-body {{ $compact ? 'p-3' : 'p-3 p-md-4' }}">
            <div class="row align-items-center g-3">
                <div class="{{ $showCta ? 'col-lg-8' : 'col-lg-9' }}">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <span class="badge bg-danger rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem; color: #ffffff !important;">
                            🔥 PROMO PENDAFTAR BARU
                        </span>
                        <span class="badge border border-warning rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem; background-color: #ffffff !important; color: #0f172a !important;">
                            Kode: <span class="font-monospace" style="color: #1d4ed8 !important;">{{ $promo24h['code'] }}</span>
                        </span>
                    </div>
                    <h5 class="fw-bold mb-1" style="color: #0f172a !important;">
                        Diskon Rp {{ number_format($promo24h['discount_amount'], 0, ',', '.') }} Berakhir {{ $promo24h['deadline_label'] ?? 'dalam 2 Jam' }}!
                    </h5>
                    <p class="small mb-0" style="color: #334155 !important;">
                        Tryout Mandiri jadi <strong style="color: #0f172a !important;">Rp 13.000</strong> <span class="text-decoration-line-through" style="color: #64748b !important;">Rp 20.000</span>
                        • Paket Super Lengkap (Unlimited + Full Materi) jadi <strong style="color: #1d4ed8 !important;">Rp 42.000</strong> <span class="text-decoration-line-through" style="color: #64748b !important;">Rp 49.000</span>
                    </p>
                </div>

                <div class="{{ $showCta ? 'col-lg-4' : 'col-lg-3' }} text-lg-end">
                    <div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                        <div class="rounded-3 px-3 py-2 text-center shadow-xs" style="background-color: #0f172a !important; color: #ffffff !important;">
                            <span class="d-block fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px; color: #fbbf24 !important;">SISA WAKTU PROMO</span>
                            <span class="font-monospace fw-bolder fs-5 promo-24h-timer" style="letter-spacing: 1px; color: #ffffff !important;">--:--:--</span>
                        </div>
                        @if ($showCta)
                            <a href="{{ route('user.pilih-paket') }}" class="btn btn-danger fw-bold rounded-pill px-4 py-2.5 shadow-sm text-nowrap" style="color: #ffffff !important;">
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
