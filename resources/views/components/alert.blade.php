@props([
    'type' => 'danger',
    'title' => null,
])

@php
    $map = [
        'danger' => ['icon' => 'bi bi-x-circle-fill', 'title' => $title ?? 'Terjadi Kesalahan'],
        'success' => ['icon' => 'bi bi-check-circle-fill', 'title' => $title ?? 'Berhasil'],
        'warning' => ['icon' => 'bi bi-exclamation-triangle-fill', 'title' => $title ?? 'Peringatan'],
        'info' => ['icon' => 'bi bi-info-circle-fill', 'title' => $title ?? 'Informasi'],
    ];
@endphp

@if ($slot->isNotEmpty())
    <div class="alert alert-{{ $type }} alert-dismissible fade show shadow-sm d-flex mb-3 align-items-start gap-3"
        role="alert">

        <div class="alert-icon fs-4">
            <i class="{{ $map[$type]['icon'] }}"></i>
        </div>

        <div>
            <h6 class="fw-semibold mb-1">{{ $map[$type]['title'] }}</h6>
            <div class="small">{{ $slot }}</div>
        </div>

        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif
