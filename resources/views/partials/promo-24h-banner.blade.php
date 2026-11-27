@php
    $promo24h = $promo24h ?? (auth()->check() ? auth()->user()->newMemberPromo() : null);
    $showCta = $showCta ?? true;
    $compact = $compact ?? false;
@endphp

@if ($promo24h)
    @php
        $discAmount = (int) ($promo24h['discount_amount'] ?? 7000);
        $hargaMandiriPromo = max(0, 20000 - $discAmount);
        $hargaLengkapPromo = max(0, 49000 - $discAmount);
        $remainingSec = (int) ($promo24h['remaining_seconds'] ?? 0);
        $progressPct = min(100, max(3, (int) round(($remainingSec / 7200) * 100)));
        $isUrgent = $remainingSec <= 1800;
    @endphp
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden promo-24h-banner {{ $isUrgent ? 'promo-urgent-border' : '' }}"
         data-remaining-seconds="{{ $remainingSec }}"
         style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 55%, #fde68a 100%) !important; border: 1.5px solid {{ $isUrgent ? '#dc2626' : '#f59e0b' }} !important; color: #1e293b !important;">
        <div class="card-body {{ $compact ? 'p-3' : 'p-3 p-md-4' }}">
            <div class="row align-items-center g-3">
                <div class="{{ $showCta ? 'col-lg-8' : 'col-lg-9' }}">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <span class="badge bg-danger rounded-pill px-2.5 py-1 fw-bold promo-urgency-badge {{ $isUrgent ? 'promo-urgent-pulse' : '' }}" style="font-size: 0.72rem; color: #ffffff !important;">
                            {{ $isUrgent ? '⚡ HAMPIR HABIS!' : '🔥 PROMO PENDAFTAR BARU' }}
                        </span>
                        <span class="badge border border-warning rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem; background-color: #ffffff !important; color: #0f172a !important;">
                            Kode: <span class="font-monospace" style="color: #1d4ed8 !important;">{{ $promo24h['code'] }}</span>
                        </span>
                    </div>
                    <h5 class="fw-bold mb-1" style="color: #0f172a !important;">
                        Diskon Rp {{ number_format($discAmount, 0, ',', '.') }} Berakhir {{ $promo24h['deadline_label'] ?? 'dalam 2 Jam' }}!
                    </h5>
                    <p class="small mb-2" style="color: #334155 !important;">
                        Tryout Mandiri jadi <strong style="color: #0f172a !important;">Rp {{ number_format($hargaMandiriPromo, 0, ',', '.') }}</strong> <span class="text-decoration-line-through" style="color: #64748b !important;">Rp 20.000</span>
                        &bull; Paket Super Lengkap (Unlimited + Full Materi) jadi <strong style="color: #1d4ed8 !important;">Rp {{ number_format($hargaLengkapPromo, 0, ',', '.') }}</strong> <span class="text-decoration-line-through" style="color: #64748b !important;">Rp 49.000</span>
                    </p>
                    <div class="progress rounded-pill" style="height: 6px; background-color: rgba(15, 23, 42, 0.12) !important;">
                        <div class="progress-bar {{ $isUrgent ? 'bg-danger' : 'bg-warning' }} promo-24h-progress" role="progressbar" style="width: {{ $progressPct }}%; transition: width 0.5s ease;"></div>
                    </div>
                </div>

                <div class="{{ $showCta ? 'col-lg-4' : 'col-lg-3' }} text-lg-end">
                    <div class="d-flex flex-wrap align-items-center {{ $showCta ? 'justify-content-between justify-content-lg-end' : 'justify-content-start justify-content-lg-end' }} gap-2">
                        <div class="rounded-3 px-3 py-2 text-center shadow-xs" style="background-color: #0f172a !important; color: #ffffff !important;">
                            <span class="d-block fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px; color: #fbbf24 !important;">SISA WAKTU PROMO</span>
                            <span class="font-monospace fw-bolder fs-5 promo-24h-timer" style="letter-spacing: 1px; color: {{ $isUrgent ? '#fca5a5' : '#ffffff' }} !important;">--:--:--</span>
                        </div>
                        @if ($showCta)
                            <a href="{{ route('user.pilih-paket') }}" class="btn btn-danger fw-bold rounded-pill px-4 py-2.5 shadow-sm text-nowrap flex-grow-1 flex-lg-grow-0 text-center" style="color: #ffffff !important;">
                                Klaim Diskon <i class="fe fe-arrow-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.promo-countdown-assets')
@endif
