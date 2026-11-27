@php
    $accordionId = $accordionId ?? 'accordionChapters';
@endphp

<!-- Progress Belajar Kategori -->
<div class="card border-0 shadow-sm rounded-4 mb-3 p-3 border">
    <div class="d-flex justify-content-between align-items-center mb-1.5">
        <span class="small fw-bold text-dark">Progres Belajar</span>
        <span class="small fw-bold text-success js-progress-summary">
            {{ $completedCategoryCount ?? 0 }}/{{ $totalCategoryMaterials ?? 0 }} ({{ $progressPercent ?? 0 }}%)
        </span>
    </div>
    <div class="progress rounded-pill" style="height: 8px;">
        <div class="progress-bar bg-success rounded-pill js-progress-bar" role="progressbar"
            style="width: {{ $progressPercent ?? 0 }}%;"
            aria-valuenow="{{ $progressPercent ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

<div class="accordion" id="{{ $accordionId }}">
    @foreach ($chapters as $chapter)
        @php
            $isActiveChapter = $chapter->id == $currentMaterial->learning_chapter_id;
            $collapseTargetId = $accordionId . '_collapse_' . $chapter->id;
        @endphp

        <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
            <h2 class="accordion-header">
                <button
                    class="accordion-button fw-bold py-2.5 px-3 {{ $isActiveChapter ? '' : 'collapsed' }}"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#{{ $collapseTargetId }}"
                    aria-expanded="{{ $isActiveChapter ? 'true' : 'false' }}">
                    <span class="small">{{ $chapter->title }}</span>
                </button>
            </h2>

            <div id="{{ $collapseTargetId }}"
                class="accordion-collapse collapse {{ $isActiveChapter ? 'show' : '' }}"
                data-bs-parent="#{{ $accordionId }}">

                <div class="accordion-body p-2">
                    @foreach ($chapter->materials as $materi)
                        @php
                            $canAccess = (isset($hasFullAccess) && $hasFullAccess) || !$materi->is_locked;
                            $isDone = in_array($materi->id, $completedMaterialIds ?? []);
                            $isCurrent = $currentMaterial->id == $materi->id;
                        @endphp

                        @if ($canAccess)
                            <a href="{{ route('materi.show', [$category->slug, $materi->slug]) }}"
                                class="materi-link d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ $isCurrent ? 'active bg-primary-soft text-primary fw-bold' : 'text-dark' }}">
                                <div class="d-flex align-items-start gap-2 min-w-0">
                                    @if ($isDone)
                                        <i class="bi bi-check-circle-fill text-success fs-6 flex-shrink-0 js-materi-icon-{{ $materi->id }}"></i>
                                    @elseif ($isCurrent)
                                        <i class="bi bi-play-circle-fill text-primary fs-6 flex-shrink-0 js-materi-icon-{{ $materi->id }}"></i>
                                    @else
                                        <i class="bi bi-circle text-muted fs-6 flex-shrink-0 js-materi-icon-{{ $materi->id }}"></i>
                                    @endif
                                    <span class="small">{{ $materi->title }}</span>
                                </div>
                            </a>
                        @else
                            <a href="javascript:void(0);"
                                role="button"
                                data-bs-toggle="modal"
                                data-bs-target="#modalLockedMaterial"
                                data-material-name="{{ $materi->title }}"
                                class="materi-link locked d-flex align-items-center justify-content-between gap-2 p-2 rounded text-decoration-none">
                                <div class="d-flex align-items-start gap-2 min-w-0">
                                    <i class="bi bi-lock-fill text-danger fs-6 flex-shrink-0"></i>
                                    <span class="small text-secondary">{{ $materi->title }}</span>
                                </div>
                                <span class="badge bg-danger text-white rounded-pill px-2 py-0.5 flex-shrink-0" style="font-size: 0.65rem;">PRO</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
