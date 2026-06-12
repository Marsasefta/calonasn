<!doctype html>
<html lang="en">
<head>
    @include('partials.head')
    <style>
        .blast-template {
            min-height: 330px;
            line-height: 1.6;
        }

        .blast-preview {
            white-space: pre-wrap;
            min-height: 220px;
            max-height: 420px;
            overflow-y: auto;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
        }

        .user-table-wrapper {
            max-height: 560px;
            overflow-y: auto;
        }

        .user-row.is-selected {
            background: #eff6ff;
        }
    </style>
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <main id="page-content">
            @include('partials.dashboard-header')

            <section class="container-fluid p-4">
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">
                        <div>
                            <h1 class="mb-1 h2 fw-bold">Blast WhatsApp</h1>
                            <p class="text-muted mb-0">Buat template pesan, pilih peserta, lalu kirim melalui Fonnte.</p>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-users me-1"></i> Kelola Peserta
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Periksa kembali form:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.whatsapp-blast.send') }}" method="POST" id="blastForm">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-xl-5 col-lg-12">
                            <div class="card h-100">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Template WhatsApp</h5>
                                        <span class="small text-muted">Gunakan placeholder <code>[Nama]</code> untuk nama peserta.</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="message" class="form-label fw-semibold">Isi Pesan</label>
                                        <textarea
                                            name="message"
                                            id="message"
                                            class="form-control blast-template @error('message') is-invalid @enderror"
                                            required
                                        >{{ old('message', $defaultTemplate) }}</textarea>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="text-muted">Fonnte akan menerima placeholder nama sebagai <code>{name}</code>.</small>
                                            <small class="text-muted"><span id="charCount">0</span> karakter</small>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-items-end">
                                        <div class="col-sm-6">
                                            <label for="delay" class="form-label fw-semibold">Delay per pesan</label>
                                            <div class="input-group">
                                                <input
                                                    type="number"
                                                    name="delay"
                                                    id="delay"
                                                    class="form-control"
                                                    value="{{ old('delay', 2) }}"
                                                    min="1"
                                                    max="60"
                                                >
                                                <span class="input-group-text">detik</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-outline-primary w-100" id="resetTemplate">
                                                <i class="fe fe-refresh-cw me-1"></i> Reset Template
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-7 col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex flex-column flex-md-row justify-content-between gap-3">
                                    <div>
                                        <h5 class="mb-0">Daftar Peserta</h5>
                                        <span class="small text-muted">Pilih peserta yang memiliki nomor WhatsApp aktif.</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <input type="search" id="userSearch" class="form-control form-control-sm" placeholder="Cari nama, email, telepon">
                                        <button type="submit" class="btn btn-success btn-sm flex-shrink-0" id="sendButton">
                                            <i class="fe fe-send me-1"></i> Kirim
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive user-table-wrapper">
                                    <table class="table table-hover align-middle mb-0" id="blastUsersTable">
                                        <thead class="table-light position-sticky top-0">
                                            <tr>
                                                <th style="width: 48px;">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                </th>
                                                <th>Peserta</th>
                                                <th>Telepon</th>
                                                <th>Status</th>
                                                <th>Terdaftar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $user)
                                                @php
                                                    $hasPhone = filled($user->phone);
                                                @endphp
                                                <tr class="user-row" data-search="{{ strtolower($user->name . ' ' . $user->email . ' ' . $user->phone) }}">
                                                    <td>
                                                        <input
                                                            class="form-check-input user-checkbox"
                                                            type="checkbox"
                                                            name="user_ids[]"
                                                            value="{{ $user->id }}"
                                                            data-name="{{ $user->name }}"
                                                            @disabled(! $hasPhone)
                                                            @checked(in_array($user->id, old('user_ids', [])))
                                                        >
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold">{{ $user->name }}</div>
                                                        <div class="small text-muted">{{ $user->email }}</div>
                                                    </td>
                                                    <td>{{ $user->phone ?? '-' }}</td>
                                                    <td>
                                                        @if($hasPhone)
                                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Siap kirim</span>
                                                        @else
                                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Tanpa nomor</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada peserta terdaftar.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row gy-4">
                                <div class="col-md-5">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <span class="text-uppercase text-muted small fw-semibold">Ringkasan</span>
                                            <h3 class="fw-bold mt-2 mb-1"><span id="selectedCount">0</span> peserta</h3>
                                            <p class="text-muted mb-0 small">Pesan akan dikirim ke peserta yang dicentang dan memiliki nomor WhatsApp.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Preview Pesan</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="blast-preview" id="messagePreview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>

    @include('partials.scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const defaultTemplate = @json($defaultTemplate);
            const messageInput = document.getElementById('message');
            const preview = document.getElementById('messagePreview');
            const charCount = document.getElementById('charCount');
            const selectedCount = document.getElementById('selectedCount');
            const checkboxes = Array.from(document.querySelectorAll('.user-checkbox'));
            const selectAll = document.getElementById('selectAll');
            const searchInput = document.getElementById('userSearch');
            const form = document.getElementById('blastForm');

            function selectedBoxes() {
                return checkboxes.filter((checkbox) => checkbox.checked && !checkbox.disabled);
            }

            function updateRows() {
                checkboxes.forEach((checkbox) => {
                    checkbox.closest('tr').classList.toggle('is-selected', checkbox.checked);
                });
            }

            function updatePreview() {
                const firstSelected = selectedBoxes()[0];
                const sampleName = firstSelected ? firstSelected.dataset.name : 'Nama Peserta';
                const message = messageInput.value.replaceAll('[Nama]', sampleName).replaceAll('{name}', sampleName);

                preview.textContent = message;
                charCount.textContent = messageInput.value.length;
                selectedCount.textContent = selectedBoxes().length;
                updateRows();
            }

            messageInput.addEventListener('input', updatePreview);
            checkboxes.forEach((checkbox) => checkbox.addEventListener('change', updatePreview));

            selectAll.addEventListener('change', function () {
                checkboxes.forEach((checkbox) => {
                    const rowVisible = checkbox.closest('tr').style.display !== 'none';

                    if (!checkbox.disabled && rowVisible) {
                        checkbox.checked = selectAll.checked;
                    }
                });

                updatePreview();
            });

            searchInput.addEventListener('input', function () {
                const keyword = searchInput.value.trim().toLowerCase();

                document.querySelectorAll('.user-row').forEach((row) => {
                    row.style.display = row.dataset.search.includes(keyword) ? '' : 'none';
                });
            });

            document.getElementById('resetTemplate').addEventListener('click', function () {
                messageInput.value = defaultTemplate;
                updatePreview();
            });

            form.addEventListener('submit', function (event) {
                const totalSelected = selectedBoxes().length;

                if (totalSelected === 0) {
                    event.preventDefault();
                    alert('Pilih minimal satu peserta dengan nomor WhatsApp.');
                    return;
                }

                if (!confirm('Kirim blast WhatsApp ke ' + totalSelected + ' peserta terpilih?')) {
                    event.preventDefault();
                }
            });

            updatePreview();
        });
    </script>
</body>
</html>
