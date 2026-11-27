<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>Zona Refreshing - Flappy ASN | CalonASN</title>
    <style>
        .game-shell {
            max-width: 1180px;
            margin: 0 auto;
        }

        .game-hero-card {
            background: linear-gradient(135deg, #1e3a8a 0%, #0f766e 100%) !important;
            color: #ffffff;
        }

        .game-canvas-wrap {
            position: relative;
            width: 100%;
            max-width: 390px;
            max-width: clamp(230px, calc((100dvh - 76px) * 0.72), 390px);
            aspect-ratio: 360 / 500;
            margin: 0 auto;
            border-radius: 1.15rem;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.25);
            border: 3px solid rgba(59, 130, 246, 0.35);
            background: #0f172a;
            touch-action: none;
            user-select: none;
            -webkit-user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        #flappyCanvas {
            display: block;
            width: 100%;
            height: 100%;
            cursor: pointer;
            touch-action: none;
        }

        .game-hud {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            pointer-events: none;
            z-index: 5;
        }

        .hud-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.72);
            color: #f8fafc;
            font-weight: 700;
            font-size: 0.85rem;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .hud-pill.hud-timer-danger {
            background: rgba(220, 38, 38, 0.88);
            border-color: rgba(254, 202, 202, 0.6);
            animation: hudPulse 0.6s infinite alternate;
        }

        @keyframes hudPulse {
            from { transform: scale(1); }
            to { transform: scale(1.06); }
        }

        .game-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
            overflow-y: auto;
            background: rgba(15, 23, 42, 0.78);
            backdrop-filter: blur(5px);
            z-index: 10;
            transition: opacity 0.18s ease;
        }

        .game-overlay.d-none {
            display: none !important;
        }

        .game-overlay-card {
            width: 100%;
            max-width: 325px;
            margin: auto;
            border-radius: 1rem;
            padding: 20px;
            background: rgba(30, 41, 59, 0.94);
            color: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.25);
            box-shadow: 0 14px 32px rgba(0, 0, 0, 0.35);
            text-align: center;
        }

        @media (max-width: 575.98px) {
            .game-hud {
                top: 10px;
                left: 10px;
                right: 10px;
            }

            .hud-pill {
                padding: 4px 10px;
                font-size: 0.78rem;
            }

            .game-overlay-card {
                padding: 14px 12px;
            }

            .game-overlay-card .display-5 {
                font-size: 2.1rem;
            }

            .game-overlay-card .display-6 {
                font-size: 1.85rem;
            }
        }

        .game-overlay-card .text-muted-light {
            color: #cbd5e1;
        }

        .lb-item {
            border-radius: 0.75rem;
            padding: 10px 12px;
            transition: background-color 0.15s ease;
        }

        .lb-item-me {
            background: rgba(37, 99, 235, 0.12);
            border: 1px solid rgba(37, 99, 235, 0.35);
        }

        [data-bs-theme="dark"] .lb-item-me {
            background: rgba(59, 130, 246, 0.18);
            border-color: rgba(96, 165, 250, 0.45);
        }

        .lb-rank-badge {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content">
        <div class="container-fluid py-4">
            <div class="game-shell">

                @include('partials.promo-24h-banner', ['showCta' => true, 'promo24h' => $promo24h])

                <!-- HERO BANNER -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 game-hero-card bg-gradient">
                    <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill px-3 py-1 fw-semibold" style="background: rgba(255,255,255,0.18); color: #fff;">
                                    🎮 Zona Refreshing
                                </span>
                                @if ($hasFullAccess)
                                    <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-semibold">
                                        <i class="bi bi-infinity me-1"></i> Akses Unlimited ({{ $packageLabel }})
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold" id="heroTrialBadge">
                                        <i class="bi bi-hourglass-split me-1"></i> Trial {{ $trialSeconds }}s ({{ $trialsRemaining }}/{{ $trialLimit }} hari ini)
                                    </span>
                                @endif
                            </div>
                            <h3 class="fw-bold text-white mb-1">Flappy ASN — Istirahat Sejenak!</h3>
                            <p class="mb-0 small" style="color: rgba(255,255,255,0.86);">
                                Capek ngerjain soal SKD? Tap-tap dulu biar fokus balik tajam. Jangan sampai terlalu lama main ya—target CPNS tetap nomor 1!
                            </p>
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2 flex-shrink-0">
                            <button type="button" id="soundToggleBtn" class="btn btn-sm rounded-pill px-3 fw-semibold"
                                style="background: rgba(255,255,255,0.18); color: #fff; border: 1px solid rgba(255,255,255,0.28);">
                                <i class="bi bi-volume-up-fill me-1" id="soundToggleIcon"></i>
                                <span id="soundToggleText">Suara ON</span>
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali Belajar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- MAIN 2-COLUMN GAME + LEADERBOARD -->
                <div class="row g-4 align-items-start">
                    <!-- LEFT: GAME ARENA -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                    <div>
                                        <h5 class="fw-bold mb-0">Arena Flappy ASN</h5>
                                        <small class="text-muted d-sm-none">Tap layar untuk terbang</small>
                                        <small class="text-muted d-none d-sm-inline">Tap layar, klik mouse, atau tekan <strong>Spasi / Panah Atas</strong></small>
                                    </div>
                                    @if (!$hasFullAccess)
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning rounded-pill px-3 py-2" id="trialsRemainingBadge">
                                            Sisa Trial Hari Ini: <strong id="trialsRemainingText">{{ $trialsRemaining }}</strong>/{{ $trialLimit }}
                                        </span>
                                    @else
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                            Rekor Terbaikmu: <strong id="headerBestScore">{{ $myBestScore }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="game-canvas-wrap" id="gameCanvasWrap">
                                    <canvas id="flappyCanvas" width="360" height="500" aria-label="Game Flappy ASN"></canvas>

                                    <!-- LIVE HUD -->
                                    <div class="game-hud">
                                        <div class="hud-pill">
                                            <i class="bi bi-trophy-fill text-warning"></i>
                                            <span>Skor: <span id="hudScore">0</span></span>
                                        </div>

                                        @if (!$hasFullAccess)
                                            <div class="hud-pill" id="trialTimerHud">
                                                <i class="bi bi-stopwatch-fill text-info"></i>
                                                <span id="trialTimerText">{{ number_format($trialSeconds, 1) }}s</span>
                                            </div>
                                        @else
                                            <div class="hud-pill">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <span>Best: <span id="hudBest">{{ $myBestScore }}</span></span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- OVERLAY MODAL INSIDE CANVAS -->
                                    <div class="game-overlay" id="gameOverlay">
                                        <div class="game-overlay-card" id="overlayContent">
                                            {{-- Populated cleanly on load by JS state --}}
                                        </div>
                                    </div>
                                </div>

                                @if (!$hasFullAccess)
                                    <div class="alert alert-warning border-0 rounded-4 mt-3 mb-0 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
                                        <div class="small">
                                            <strong>Mode Trial ({{ $trialSeconds }} Detik &times; {{ $trialLimit }}x/hari):</strong>
                                            Upgrade ke Paket 1, 2, atau 3 untuk main <strong>Unlimited</strong> dan masuk <strong>Top 10 Leaderboard</strong>!
                                        </div>
                                        <a href="{{ route('user.pilih-paket') }}" class="btn btn-warning btn-sm rounded-pill fw-bold text-nowrap px-3">
                                            Lihat Paket
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: PERSONAL STATS & LEADERBOARD -->
                    <div class="col-lg-5">
                        <!-- STATS CARD -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                    <h5 class="fw-bold mb-0"><i class="bi bi-person-badge-fill text-primary me-2"></i>Status Pemain</h5>
                                    <span class="badge {{ $hasFullAccess ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} rounded-pill px-3 py-1">
                                        {{ $packageLabel }}
                                    </span>
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="p-3 rounded-3 border text-center">
                                            <div class="small text-muted mb-1">Rekor Terbaik</div>
                                            <div class="fs-3 fw-bold text-primary" id="myBestScoreVal">{{ $myBestScore }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded-3 border text-center">
                                            <div class="small text-muted mb-1">Mode Akses</div>
                                            @if ($hasFullAccess)
                                                <div class="fs-5 fw-bold text-success mt-1">Unlimited</div>
                                            @else
                                                <div class="fs-5 fw-bold text-warning mt-1" id="statTrialMode">
                                                    {{ $trialSeconds }}s &times; {{ $trialsRemaining }}/{{ $trialLimit }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 mt-3">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill fw-semibold">
                                        <i class="bi bi-journal-check me-1"></i> Lanjut Belajar / Tryout
                                    </a>
                                    @if (!$hasFullAccess)
                                        <a href="{{ route('user.pilih-paket') }}" class="btn btn-warning rounded-pill fw-bold">
                                            <i class="bi bi-unlock-fill me-1"></i> Buka Akses Full + Tryout
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- TOP 10 LEADERBOARD CARD -->
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h5 class="fw-bold mb-0">
                                        <i class="bi bi-trophy-fill text-warning me-2"></i>Top 10 Leaderboard
                                    </h5>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill">Member Aktif</span>
                                </div>
                                <p class="text-muted small mb-3">
                                    Khusus peserta Paket 1, 2, dan 3. Nama disamarkan demi privasi peserta.
                                </p>

                                <div id="leaderboardList" class="d-flex flex-column gap-2">
                                    @forelse ($leaderboard as $row)
                                        @php
                                            $isMe = (int) $row['user_id'] === (int) auth()->id();
                                            $rank = (int) $row['rank'];
                                            $rankDisplay = match ($rank) {
                                                1 => '🥇',
                                                2 => '🥈',
                                                3 => '🥉',
                                                default => '#' . $rank,
                                            };
                                            $rankClass = match ($rank) {
                                                1 => 'bg-warning text-dark',
                                                2 => 'bg-secondary-subtle text-secondary-emphasis',
                                                3 => 'bg-danger-subtle text-danger-emphasis',
                                                default => 'bg-light text-dark border',
                                            };
                                        @endphp
                                        <div class="lb-item d-flex align-items-center justify-content-between gap-2 border {{ $isMe ? 'lb-item-me' : '' }}">
                                            <div class="d-flex align-items-center gap-2 min-w-0">
                                                <span class="lb-rank-badge {{ $rankClass }}">{{ $rankDisplay }}</span>
                                                <div class="min-w-0">
                                                    <div class="fw-bold text-truncate">
                                                        {{ $row['name'] }}
                                                        @if ($isMe)
                                                            <span class="badge bg-primary rounded-pill ms-1" style="font-size: 0.68rem;">Kamu</span>
                                                        @endif
                                                    </div>
                                                    <div class="small text-muted text-truncate">{{ $row['package_label'] }}</div>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">
                                                {{ $row['best_score'] }} pts
                                            </span>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted small border rounded-3">
                                            <i class="bi bi-controller fs-3 d-block mb-1"></i>
                                            Belum ada skor tercatat. Jadilah juara #1 di Leaderboard!
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('partials.btn-scroll-top')
    @include('partials.scripts')

    <script>
        (function () {
            const CONFIG = {
                hasFullAccess: @json($hasFullAccess),
                trialSeconds: @json($trialSeconds),
                trialLimit: @json($trialLimit),
                trialsUsed: @json($trialsUsed),
                trialsRemaining: @json($trialsRemaining),
                myBestScore: @json($myBestScore),
                currentUserId: @json((int) auth()->id()),
                promo24h: @json($promo24h),
                routes: {
                    trial: @json(route('game.trial')),
                    score: @json(route('game.score')),
                    pilihPaket: @json(route('user.pilih-paket')),
                    dashboard: @json(route('dashboard')),
                },
                csrfToken: @json(csrf_token()),
            };

            const PIPE_LABELS = ['TWK', 'TIU', 'TKP', 'BKN', 'HOTS', 'SKD'];
            const LOGICAL_W = 360;
            const LOGICAL_H = 500;
            const GROUND_H = 46;

            const canvas = document.getElementById('flappyCanvas');
            const ctx = canvas.getContext('2d');
            const canvasWrap = document.getElementById('gameCanvasWrap');
            const overlayEl = document.getElementById('gameOverlay');
            const overlayContentEl = document.getElementById('overlayContent');
            const hudScoreEl = document.getElementById('hudScore');
            const hudBestEl = document.getElementById('hudBest');
            const trialTimerHudEl = document.getElementById('trialTimerHud');
            const trialTimerTextEl = document.getElementById('trialTimerText');
            const soundToggleBtn = document.getElementById('soundToggleBtn');
            const soundToggleIcon = document.getElementById('soundToggleIcon');
            const soundToggleText = document.getElementById('soundToggleText');

            // DPR scaling for crisp Canvas rendering
            function setupCanvasDpr() {
                const dpr = Math.min(window.devicePixelRatio || 1, 2);
                canvas.width = LOGICAL_W * dpr;
                canvas.height = LOGICAL_H * dpr;
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            }
            setupCanvasDpr();
            window.addEventListener('resize', setupCanvasDpr);

            // Web Audio Synth SFX
            let audioCtx = null;
            let isMuted = localStorage.getItem('flappy_asn_muted') === '1';

            function updateSoundButton() {
                if (isMuted) {
                    soundToggleIcon.className = 'bi bi-volume-mute-fill me-1';
                    soundToggleText.textContent = 'Suara OFF';
                } else {
                    soundToggleIcon.className = 'bi bi-volume-up-fill me-1';
                    soundToggleText.textContent = 'Suara ON';
                }
            }
            updateSoundButton();

            soundToggleBtn.addEventListener('click', function () {
                isMuted = !isMuted;
                localStorage.setItem('flappy_asn_muted', isMuted ? '1' : '0');
                updateSoundButton();
            });

            function playTone(freq, duration, type, gainVal, endFreq) {
                if (isMuted) return;
                try {
                    const AudioContextCtor = window.AudioContext || window.webkitAudioContext;
                    if (!AudioContextCtor) return;
                    if (!audioCtx) audioCtx = new AudioContextCtor();
                    if (audioCtx.state === 'suspended') audioCtx.resume();

                    const osc = audioCtx.createOscillator();
                    const gain = audioCtx.createGain();
                    osc.type = type || 'sine';
                    osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
                    if (endFreq) {
                        osc.frequency.exponentialRampToValueAtTime(endFreq, audioCtx.currentTime + duration);
                    }
                    gain.gain.setValueAtTime(gainVal || 0.12, audioCtx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration);
                    osc.connect(gain);
                    gain.connect(audioCtx.destination);
                    osc.start();
                    osc.stop(audioCtx.currentTime + duration);
                } catch (_) {}
            }

            const sfx = {
                flap: () => playTone(380, 0.08, 'triangle', 0.1, 560),
                score: () => {
                    playTone(660, 0.08, 'sine', 0.12, 880);
                    setTimeout(() => playTone(990, 0.1, 'sine', 0.1), 55);
                },
                hit: () => playTone(180, 0.22, 'sawtooth', 0.14, 70),
                trialEnd: () => {
                    playTone(523, 0.12, 'triangle', 0.12);
                    setTimeout(() => playTone(392, 0.18, 'triangle', 0.12), 110);
                },
            };

            // Game state
            let state = {
                phase: 'idle', // 'idle' | 'ready' | 'playing' | 'gameover' | 'trial_expired' | 'locked'
                score: 0,
                bird: { x: 92, y: 225, vy: 0, radius: 14, rot: 0, wingPhase: 0 },
                pipes: [],
                pipeIndex: 0,
                groundOffset: 0,
                cloudOffset: 0,
                lastFrameAt: 0,
                hasFlappedOnce: false,
                trialStartAt: 0,
                trialElapsed: 0,
                isStartingTrial: false,
                isSavingScore: false,
            };

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text == null ? '' : String(text);
                return div.innerHTML;
            }

            function resetEntities() {
                state.score = 0;
                state.bird = { x: 92, y: 225, vy: 0, radius: 14, rot: 0, wingPhase: 0 };
                state.pipes = [];
                state.pipeIndex = 0;
                state.hasFlappedOnce = false;
                state.trialStartAt = 0;
                state.trialElapsed = 0;
                hudScoreEl.textContent = '0';
                updateTrialHud(CONFIG.trialSeconds);
            }

            function updateTrialHud(secondsLeft) {
                if (CONFIG.hasFullAccess || !trialTimerTextEl || !trialTimerHudEl) return;
                const clamped = Math.max(0, secondsLeft);
                trialTimerTextEl.textContent = clamped.toFixed(1) + 's';
                if (state.phase === 'playing' && state.hasFlappedOnce && clamped <= 2.0) {
                    trialTimerHudEl.classList.add('hud-timer-danger');
                } else {
                    trialTimerHudEl.classList.remove('hud-timer-danger');
                }
            }

            function updateTrialCountersDom() {
                if (CONFIG.hasFullAccess) return;
                const rem = Math.max(0, CONFIG.trialsRemaining || 0);
                const heroBadge = document.getElementById('heroTrialBadge');
                const remText = document.getElementById('trialsRemainingText');
                const statMode = document.getElementById('statTrialMode');
                if (heroBadge) {
                    heroBadge.innerHTML = `<i class="bi bi-hourglass-split me-1"></i> Trial ${CONFIG.trialSeconds}s (${rem}/${CONFIG.trialLimit} hari ini)`;
                }
                if (remText) remText.textContent = String(rem);
                if (statMode) statMode.innerHTML = `${CONFIG.trialSeconds}s &times; ${rem}/${CONFIG.trialLimit}`;
            }

            function promoCtaLabel() {
                if (CONFIG.promo24h && CONFIG.promo24h.code) {
                    return `Upgrade Paket (Promo ${escapeHtml(CONFIG.promo24h.code)})`;
                }
                return 'Buka Akses Unlimited';
            }

            function showOverlay(html) {
                overlayContentEl.innerHTML = html;
                overlayEl.classList.remove('d-none');
            }

            function hideOverlay() {
                overlayEl.classList.add('d-none');
            }

            function renderStartOverlay() {
                if (!CONFIG.hasFullAccess && (CONFIG.trialsRemaining || 0) <= 0) {
                    renderLockedOverlay();
                    return;
                }
                state.phase = 'idle';
                const subtitle = CONFIG.hasFullAccess
                    ? `Akses Unlimited aktif. Cetak skor tertinggi dan kuasai Top 10 Leaderboard!`
                    : `Mode Free mendapat <strong>${CONFIG.trialLimit}x trial / hari</strong> (${CONFIG.trialSeconds} detik per ronde). Timer mulai saat tap pertama!`;

                const badgeHtml = CONFIG.hasFullAccess
                    ? `<span class="badge bg-success rounded-pill mb-2">Unlimited Mode</span>`
                    : `<span class="badge bg-warning text-dark rounded-pill mb-2">Sisa Trial Hari Ini: ${CONFIG.trialsRemaining}/${CONFIG.trialLimit}</span>`;

                showOverlay(`
                    ${badgeHtml}
                    <h4 class="fw-bold mb-2">Flappy ASN</h4>
                    <p class="small text-muted-light mb-3">${subtitle}</p>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary rounded-pill fw-bold py-2" data-action="start-round">
                            <i class="bi bi-play-fill me-1"></i> ${CONFIG.hasFullAccess ? 'Mulai Terbang' : 'Mulai Trial (' + CONFIG.trialSeconds + ' Detik)'}
                        </button>
                    </div>
                `);
            }

            function renderLockedOverlay() {
                state.phase = 'locked';
                showOverlay(`
                    <div class="fs-2 mb-2">🔒</div>
                    <h5 class="fw-bold mb-2">Trial Hari Ini Habis (3/3)</h5>
                    <p class="small text-muted-light mb-3">
                        Kuota ${CONFIG.trialLimit}x trial (${CONFIG.trialSeconds} detik) untuk hari ini sudah terpakai.
                        Yuk lanjut persiapan CPNS atau upgrade ke Paket 1, 2, atau 3 untuk main tanpa batas!
                    </p>
                    <div class="d-grid gap-2">
                        <a href="${escapeHtml(CONFIG.routes.pilihPaket)}" class="btn btn-warning rounded-pill fw-bold text-dark">
                            <i class="bi bi-unlock-fill me-1"></i> ${promoCtaLabel()}
                        </a>
                        <a href="${escapeHtml(CONFIG.routes.dashboard)}" class="btn btn-outline-light btn-sm rounded-pill">
                            Kembali Belajar / Tryout
                        </a>
                    </div>
                `);
            }

            function renderTrialEndedOverlay(reasonTitle) {
                const rem = Math.max(0, CONFIG.trialsRemaining || 0);
                const retryBtn = rem > 0
                    ? `<button type="button" class="btn btn-outline-info rounded-pill fw-semibold" data-action="start-round">
                           <i class="bi bi-arrow-repeat me-1"></i> Main Trial Lagi (Sisa ${rem}x)
                       </button>`
                    : `<div class="small text-warning fw-semibold">Jatah 3x trial hari ini sudah habis!</div>`;

                showOverlay(`
                    <span class="badge bg-info text-dark rounded-pill mb-2">Ronde Trial Selesai</span>
                    <h5 class="fw-bold mb-1">${escapeHtml(reasonTitle)}</h5>
                    <div class="display-6 fw-bold text-warning my-2">${state.score} <span class="fs-6 fw-normal text-muted-light">poin</span></div>
                    <p class="small text-muted-light mb-3">
                        Mau main puas tanpa batas 5 detik &amp; tampil di Top 10 Leaderboard?
                    </p>
                    <div class="d-grid gap-2">
                        <a href="${escapeHtml(CONFIG.routes.pilihPaket)}" class="btn btn-warning rounded-pill fw-bold text-dark">
                            <i class="bi bi-star-fill me-1"></i> ${promoCtaLabel()}
                        </a>
                        ${retryBtn}
                        <a href="${escapeHtml(CONFIG.routes.dashboard)}" class="btn btn-outline-light btn-sm rounded-pill">
                            Lanjut Belajar / Tryout
                        </a>
                    </div>
                `);
            }

            function renderPaidGameOverOverlay(saveResult) {
                const isNewBest = saveResult && saveResult.is_new_best;
                const bestScore = saveResult && typeof saveResult.best_score === 'number'
                    ? saveResult.best_score
                    : Math.max(CONFIG.myBestScore, state.score);

                const badge = isNewBest
                    ? `<span class="badge bg-success rounded-pill mb-2">🎉 Rekor Baru!</span>`
                    : `<span class="badge bg-danger rounded-pill mb-2">Game Over</span>`;

                showOverlay(`
                    ${badge}
                    <h5 class="fw-bold mb-1">Skor Ronde Ini</h5>
                    <div class="display-5 fw-bold text-warning my-1">${state.score}</div>
                    <div class="small text-muted-light mb-3">Rekor Terbaikmu: <strong>${bestScore}</strong> poin</div>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary rounded-pill fw-bold py-2" data-action="start-round">
                            <i class="bi bi-arrow-repeat me-1"></i> Main Lagi (Spasi)
                        </button>
                        <a href="${escapeHtml(CONFIG.routes.dashboard)}" class="btn btn-outline-light btn-sm rounded-pill">
                            <i class="bi bi-journal-check me-1"></i> Lanjut Belajar / Tryout
                        </a>
                    </div>
                `);
            }

            function updateLeaderboardDom(rows) {
                const listEl = document.getElementById('leaderboardList');
                if (!listEl || !Array.isArray(rows)) return;

                if (rows.length === 0) {
                    listEl.innerHTML = `
                        <div class="text-center py-4 text-muted small border rounded-3">
                            <i class="bi bi-controller fs-3 d-block mb-1"></i>
                            Belum ada skor tercatat. Jadilah juara #1 di Leaderboard!
                        </div>
                    `;
                    return;
                }

                listEl.innerHTML = rows.map(function (row) {
                    const isMe = Number(row.user_id) === CONFIG.currentUserId;
                    const rank = Number(row.rank);
                    let rankDisplay = '#' + rank;
                    let rankClass = 'bg-light text-dark border';
                    if (rank === 1) { rankDisplay = '🥇'; rankClass = 'bg-warning text-dark'; }
                    else if (rank === 2) { rankDisplay = '🥈'; rankClass = 'bg-secondary-subtle text-secondary-emphasis'; }
                    else if (rank === 3) { rankDisplay = '🥉'; rankClass = 'bg-danger-subtle text-danger-emphasis'; }

                    const meBadge = isMe
                        ? `<span class="badge bg-primary rounded-pill ms-1" style="font-size: 0.68rem;">Kamu</span>`
                        : '';

                    return `
                        <div class="lb-item d-flex align-items-center justify-content-between gap-2 border ${isMe ? 'lb-item-me' : ''}">
                            <div class="d-flex align-items-center gap-2 min-w-0">
                                <span class="lb-rank-badge ${rankClass}">${rankDisplay}</span>
                                <div class="min-w-0">
                                    <div class="fw-bold text-truncate">${escapeHtml(row.name)}${meBadge}</div>
                                    <div class="small text-muted text-truncate">${escapeHtml(row.package_label)}</div>
                                </div>
                            </div>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">
                                ${Number(row.best_score)} pts
                            </span>
                        </div>
                    `;
                }).join('');
            }

            async function startNewRound() {
                if (state.isStartingTrial) return;

                if (!CONFIG.hasFullAccess) {
                    state.isStartingTrial = true;
                    showOverlay(`
                        <div class="spinner-border text-warning mb-2" role="status"></div>
                        <div class="small fw-semibold">Menyiapkan ronde trial...</div>
                    `);

                    try {
                        const res = await fetch(CONFIG.routes.trial, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': CONFIG.csrfToken,
                            },
                            body: JSON.stringify({}),
                        });
                        const data = await res.json();

                        if (typeof data.trials_used === 'number') CONFIG.trialsUsed = data.trials_used;
                        if (typeof data.trials_remaining === 'number') CONFIG.trialsRemaining = data.trials_remaining;
                        updateTrialCountersDom();

                        if (!res.ok || !data.allowed) {
                            renderLockedOverlay();
                            return;
                        }
                    } catch (err) {
                        renderStartOverlay();
                        return;
                    } finally {
                        state.isStartingTrial = false;
                    }
                }

                resetEntities();
                state.phase = 'ready';
                hideOverlay();
            }

            async function submitPaidScore(finalScore) {
                if (!CONFIG.hasFullAccess || state.isSavingScore) return;
                state.isSavingScore = true;
                try {
                    const res = await fetch(CONFIG.routes.score, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CONFIG.csrfToken,
                        },
                        body: JSON.stringify({ score: finalScore }),
                    });
                    const data = await res.json();
                    if (res.ok && data.status === 'success') {
                        CONFIG.myBestScore = Number(data.best_score);
                        const myBestEl = document.getElementById('myBestScoreVal');
                        const headerBestEl = document.getElementById('headerBestScore');
                        if (myBestEl) myBestEl.textContent = String(CONFIG.myBestScore);
                        if (headerBestEl) headerBestEl.textContent = String(CONFIG.myBestScore);
                        if (hudBestEl) hudBestEl.textContent = String(CONFIG.myBestScore);
                        if (Array.isArray(data.leaderboard)) {
                            updateLeaderboardDom(data.leaderboard);
                        }
                        if (state.phase === 'gameover') {
                            renderPaidGameOverOverlay(data);
                        }
                    }
                } catch (_) {}
                finally {
                    state.isSavingScore = false;
                }
            }

            function spawnPipe() {
                const gap = 136;
                const minTop = 62;
                const maxTop = LOGICAL_H - GROUND_H - gap - 62;
                const topHeight = minTop + Math.random() * (maxTop - minTop);
                const label = PIPE_LABELS[state.pipeIndex % PIPE_LABELS.length];
                state.pipeIndex++;

                state.pipes.push({
                    x: LOGICAL_W + 20,
                    width: 56,
                    topHeight: topHeight,
                    gap: gap,
                    passed: false,
                    label: label,
                });
            }

            function flap() {
                if (state.phase === 'ready') {
                    state.phase = 'playing';
                    state.hasFlappedOnce = true;
                    state.trialStartAt = performance.now();
                    spawnPipe();
                }

                if (state.phase !== 'playing') return;

                state.bird.vy = -375;
                state.bird.wingPhase = Math.PI;
                sfx.flap();
            }

            function endRoundCrash() {
                if (state.phase !== 'playing') return;
                sfx.hit();

                if (!CONFIG.hasFullAccess) {
                    state.phase = 'trial_expired';
                    renderTrialEndedOverlay('Nabrak Pipa! Trial Selesai');
                    return;
                }

                state.phase = 'gameover';
                renderPaidGameOverOverlay(null);
                submitPaidScore(state.score);
            }

            function endRoundTrialTimeout() {
                if (state.phase !== 'playing') return;
                state.phase = 'trial_expired';
                updateTrialHud(0);
                sfx.trialEnd();
                renderTrialEndedOverlay('Waktu Trial 5 Detik Habis!');
            }

            function updatePhysics(dt, now) {
                if (state.phase === 'idle' || state.phase === 'ready') {
                    state.groundOffset = (state.groundOffset + 85 * dt) % 24;
                    state.cloudOffset = (state.cloudOffset + 18 * dt) % LOGICAL_W;
                    state.bird.y = 225 + Math.sin(now / 260) * 8;
                    state.bird.wingPhase += dt * 10;
                    state.bird.rot = 0;
                    return;
                }

                if (state.phase !== 'playing') return;

                // Free user 5s timer starts on first tap
                if (!CONFIG.hasFullAccess && state.hasFlappedOnce) {
                    state.trialElapsed = (now - state.trialStartAt) / 1000;
                    const left = CONFIG.trialSeconds - state.trialElapsed;
                    updateTrialHud(left);
                    if (left <= 0) {
                        endRoundTrialTimeout();
                        return;
                    }
                }

                const speed = Math.min(188, 148 + state.score * 1.4);
                state.groundOffset = (state.groundOffset + speed * dt) % 24;
                state.cloudOffset = (state.cloudOffset + 24 * dt) % LOGICAL_W;

                // Bird physics
                state.bird.vy = Math.min(540, state.bird.vy + 1240 * dt);
                state.bird.y += state.bird.vy * dt;
                state.bird.wingPhase += dt * 16;
                state.bird.rot = Math.max(-0.48, Math.min(1.15, state.bird.vy / 460));

                // Ceiling & ground check
                if (state.bird.y - state.bird.radius < 0) {
                    state.bird.y = state.bird.radius;
                    state.bird.vy = 0;
                }
                if (state.bird.y + state.bird.radius >= LOGICAL_H - GROUND_H) {
                    state.bird.y = LOGICAL_H - GROUND_H - state.bird.radius;
                    endRoundCrash();
                    return;
                }

                // Pipes update & spawn
                for (let i = state.pipes.length - 1; i >= 0; i--) {
                    const p = state.pipes[i];
                    p.x -= speed * dt;

                    // Score check
                    if (!p.passed && p.x + p.width < state.bird.x) {
                        p.passed = true;
                        state.score += 1;
                        hudScoreEl.textContent = String(state.score);
                        sfx.score();
                    }

                    // Collision check (circle-rect forgiving hitbox)
                    const hitR = state.bird.radius - 2.5;
                    const withinX = state.bird.x + hitR > p.x && state.bird.x - hitR < p.x + p.width;
                    if (withinX) {
                        const hitTop = state.bird.y - hitR < p.topHeight;
                        const hitBottom = state.bird.y + hitR > p.topHeight + p.gap;
                        if (hitTop || hitBottom) {
                            endRoundCrash();
                            return;
                        }
                    }

                    if (p.x + p.width < -20) {
                        state.pipes.splice(i, 1);
                    }
                }

                const lastPipe = state.pipes[state.pipes.length - 1];
                if (!lastPipe || lastPipe.x <= LOGICAL_W - 210) {
                    spawnPipe();
                }
            }

            function drawScene() {
                // Sky gradient
                const sky = ctx.createLinearGradient(0, 0, 0, LOGICAL_H - GROUND_H);
                sky.addColorStop(0, '#0ea5e9');
                sky.addColorStop(0.65, '#7dd3fc');
                sky.addColorStop(1, '#bae6fd');
                ctx.fillStyle = sky;
                ctx.fillRect(0, 0, LOGICAL_W, LOGICAL_H - GROUND_H);

                // Soft decorative clouds
                ctx.fillStyle = 'rgba(255, 255, 255, 0.45)';
                [0, 140, 270].forEach((baseX, idx) => {
                    const cx = ((baseX - state.cloudOffset + LOGICAL_W * 2) % (LOGICAL_W + 100)) - 50;
                    const cy = 76 + idx * 44;
                    ctx.beginPath();
                    ctx.arc(cx, cy, 18, 0, Math.PI * 2);
                    ctx.arc(cx + 18, cy - 6, 22, 0, Math.PI * 2);
                    ctx.arc(cx + 38, cy, 16, 0, Math.PI * 2);
                    ctx.fill();
                });

                // Skyline silhouettes
                ctx.fillStyle = 'rgba(14, 116, 144, 0.16)';
                for (let bx = 0; bx < LOGICAL_W; bx += 48) {
                    const bh = 36 + ((bx * 13) % 42);
                    ctx.fillRect(bx + 2, LOGICAL_H - GROUND_H - bh, 38, bh);
                }

                // Pipes
                state.pipes.forEach(function (p) {
                    const pipeGrad = ctx.createLinearGradient(p.x, 0, p.x + p.width, 0);
                    pipeGrad.addColorStop(0, '#0f766e');
                    pipeGrad.addColorStop(0.55, '#14b8a6');
                    pipeGrad.addColorStop(1, '#0d9488');

                    // Top pipe body & lip
                    ctx.fillStyle = pipeGrad;
                    ctx.fillRect(p.x, 0, p.width, p.topHeight);
                    ctx.fillStyle = '#0f766e';
                    ctx.fillRect(p.x - 4, p.topHeight - 16, p.width + 8, 16);

                    // Bottom pipe body & lip
                    const bottomY = p.topHeight + p.gap;
                    const bottomH = LOGICAL_H - GROUND_H - bottomY;
                    ctx.fillStyle = pipeGrad;
                    ctx.fillRect(p.x, bottomY, p.width, bottomH);
                    ctx.fillStyle = '#0f766e';
                    ctx.fillRect(p.x - 4, bottomY, p.width + 8, 16);

                    // Pipe label pill ("TWK", "TIU", "TKP", etc.)
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.92)';
                    const pillY = Math.min(LOGICAL_H - GROUND_H - 36, bottomY + 28);
                    ctx.fillRect(p.x + 8, pillY, p.width - 16, 18);
                    ctx.fillStyle = '#0f172a';
                    ctx.font = 'bold 10px sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(p.label, p.x + p.width / 2, pillY + 9);
                });

                // Ground strip
                ctx.fillStyle = '#15803d';
                ctx.fillRect(0, LOGICAL_H - GROUND_H, LOGICAL_W, 10);
                ctx.fillStyle = '#d97706';
                ctx.fillRect(0, LOGICAL_H - GROUND_H + 10, LOGICAL_W, GROUND_H - 10);

                // Moving diagonal ground stripes
                ctx.fillStyle = 'rgba(255, 255, 255, 0.22)';
                for (let gx = -state.groundOffset; gx < LOGICAL_W + 24; gx += 24) {
                    ctx.fillRect(gx, LOGICAL_H - GROUND_H + 2, 12, 6);
                }

                // Ready prompt text on canvas
                if (state.phase === 'ready') {
                    ctx.fillStyle = 'rgba(15, 23, 42, 0.72)';
                    ctx.fillRect(54, 130, LOGICAL_W - 108, 46);
                    ctx.fillStyle = '#f8fafc';
                    ctx.font = 'bold 14px sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText('Tap / Spasi untuk Mulai Terbang!', LOGICAL_W / 2, 153);
                }

                // Bird (ASN Mascot)
                ctx.save();
                ctx.translate(state.bird.x, state.bird.y);
                ctx.rotate(state.bird.rot);

                // Wing
                const wingY = Math.sin(state.bird.wingPhase) * 4;
                ctx.fillStyle = '#fef08a';
                ctx.beginPath();
                ctx.ellipse(-4, 2 + wingY * 0.5, 9, 5, -0.25, 0, Math.PI * 2);
                ctx.fill();

                // Body
                ctx.fillStyle = '#f59e0b';
                ctx.beginPath();
                ctx.arc(0, 0, state.bird.radius, 0, Math.PI * 2);
                ctx.fill();
                ctx.lineWidth = 2;
                ctx.strokeStyle = '#78350f';
                ctx.stroke();

                // ASN Blue Topi / Cap accent
                ctx.fillStyle = '#1e3a8a';
                ctx.fillRect(-10, -state.bird.radius - 3, 20, 6);
                ctx.fillStyle = '#1d4ed8';
                ctx.fillRect(-2, -state.bird.radius - 5, 16, 4);

                // Eye
                ctx.fillStyle = '#ffffff';
                ctx.beginPath();
                ctx.arc(6, -3, 4.5, 0, Math.PI * 2);
                ctx.fill();
                ctx.fillStyle = '#0f172a';
                ctx.beginPath();
                ctx.arc(7.5, -3, 2.2, 0, Math.PI * 2);
                ctx.fill();

                // Beak
                ctx.fillStyle = '#ef4444';
                ctx.beginPath();
                ctx.moveTo(11, -1);
                ctx.lineTo(20, 3);
                ctx.lineTo(11, 6);
                ctx.closePath();
                ctx.fill();

                ctx.restore();
            }

            function loop(now) {
                if (!state.lastFrameAt) state.lastFrameAt = now;
                const dt = Math.min(0.05, Math.max(0, (now - state.lastFrameAt) / 1000));
                state.lastFrameAt = now;

                updatePhysics(dt, now);
                drawScene();

                requestAnimationFrame(loop);
            }

            // Event Listeners
            overlayContentEl.addEventListener('click', function (e) {
                const startBtn = e.target.closest('[data-action="start-round"]');
                if (startBtn) {
                    e.preventDefault();
                    startNewRound();
                }
            });

            canvas.addEventListener('pointerdown', function (e) {
                e.preventDefault();
                if (state.phase === 'ready' || state.phase === 'playing') {
                    flap();
                }
            });

            window.addEventListener('keydown', function (e) {
                const tag = (document.activeElement && document.activeElement.tagName || '').toLowerCase();
                if (tag === 'input' || tag === 'textarea' || tag === 'select') return;

                if (e.code === 'Space' || e.code === 'ArrowUp' || e.code === 'KeyW') {
                    e.preventDefault();
                    if (state.phase === 'idle' || state.phase === 'gameover') {
                        startNewRound();
                    } else if (state.phase === 'trial_expired' && !CONFIG.hasFullAccess && (CONFIG.trialsRemaining || 0) > 0) {
                        startNewRound();
                    } else if (state.phase === 'ready' || state.phase === 'playing') {
                        flap();
                    }
                }
            });

            // Initialize UI & Loop
            renderStartOverlay();
            requestAnimationFrame(loop);
        })();
    </script>
</body>

</html>
