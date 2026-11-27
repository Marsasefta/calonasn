@once
    <style>
        @keyframes promoUrgentPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.04); opacity: 0.88; }
        }
        .promo-urgent-pulse {
            animation: promoUrgentPulse 1.4s ease-in-out infinite;
        }
    </style>
    <script>
        window.initPromo24hCountdowns = window.initPromo24hCountdowns || function () {
            if (window.__promoCountdownRunning) return;
            window.__promoCountdownRunning = true;

            const containers = Array.from(document.querySelectorAll('.promo-24h-banner, .promo-global-countdown'));
            if (!containers.length) return;

            function formatTime(sec) {
                const h = String(Math.floor(sec / 3600)).padStart(2, '0');
                const m = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
                const s = String(sec % 60).padStart(2, '0');
                return h + ':' + m + ':' + s;
            }

            const items = containers.map(function (el) {
                return {
                    el: el,
                    remaining: parseInt(el.getAttribute('data-remaining-seconds') || '0', 10),
                    timers: el.querySelectorAll('.promo-24h-timer'),
                    progress: el.querySelector('.promo-24h-progress'),
                    badge: el.querySelector('.promo-urgency-badge')
                };
            });

            function tick(decrement) {
                let anyActive = false;
                items.forEach(function (item) {
                    if (decrement && item.remaining > 0) {
                        item.remaining--;
                    }
                    if (item.remaining <= 0) {
                        item.el.style.display = 'none';
                        return;
                    }
                    anyActive = true;
                    const formatted = formatTime(item.remaining);
                    item.timers.forEach(function (t) {
                        t.textContent = formatted;
                        if (item.remaining <= 1800) {
                            t.style.setProperty('color', '#fca5a5', 'important');
                        }
                    });
                    if (item.progress) {
                        const pct = Math.min(100, Math.max(3, Math.round((item.remaining / 7200) * 100)));
                        item.progress.style.width = pct + '%';
                        if (item.remaining <= 1800) {
                            item.progress.classList.remove('bg-warning');
                            item.progress.classList.add('bg-danger');
                        }
                    }
                    if (item.badge && item.remaining <= 1800) {
                        item.badge.classList.add('promo-urgent-pulse');
                        item.badge.textContent = item.badge.dataset.shortBadge === '1'
                            ? '⚡ < 30 MENIT'
                            : '⚡ HAMPIR HABIS!';
                    }
                });
                return anyActive;
            }

            if (!tick(false)) return;

            const timerId = setInterval(function () {
                if (!tick(true)) {
                    clearInterval(timerId);
                }
            }, 1000);
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', window.initPromo24hCountdowns);
        } else {
            window.initPromo24hCountdowns();
        }
    </script>
@endonce
