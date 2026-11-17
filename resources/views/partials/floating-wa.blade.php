{{-- Floating WhatsApp Pill (Landing Page) --}}
@php
    $waLandingMsg = urlencode('Halo Admin CalonASN, saya tertarik dengan program Tryout & Materi CPNS. Mau tanya-tanya informasi paketnya ya...');
@endphp

<a href="https://wa.me/6285113655806?text={{ $waLandingMsg }}"
   target="_blank"
   rel="noopener noreferrer"
   class="floating-wa-landing shadow-lg"
   title="Konsultasi Program Tryout via WhatsApp (085113655806)">
    <span class="floating-wa-icon-box">
        <i class="bi bi-whatsapp"></i>
        <span class="floating-wa-pulse"></span>
    </span>
    <span class="floating-wa-label">Konsultasi Gratis</span>
</a>

<style>
    .floating-wa-landing {
        position: fixed;
        bottom: 85px;
        right: 24px;
        z-index: 1040;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: #ffffff !important;
        padding: 11px 20px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.2px;
        text-decoration: none !important;
        box-shadow: 0 4px 18px rgba(18, 140, 126, 0.4);
        transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 2px solid rgba(255, 255, 255, 0.25);
    }

    .floating-wa-landing:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 8px 25px rgba(18, 140, 126, 0.55);
        color: #ffffff !important;
    }

    .floating-wa-landing .floating-wa-icon-box {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        line-height: 1;
    }

    .floating-wa-landing .floating-wa-pulse {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 8px;
        height: 8px;
        background-color: #ffffff;
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(255, 255, 255, 0.7);
        animation: pulse-wa-white 1.8s infinite;
    }

    @keyframes pulse-wa-white {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
        }
        70% {
            box-shadow: 0 0 0 6px rgba(255, 255, 255, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
        }
    }

    @media (max-width: 576px) {
        .floating-wa-landing {
            bottom: 80px;
            right: 16px;
            padding: 10px 16px;
            font-size: 13px;
        }
    }
</style>

