@props([
    'type' => 'info',
    'dismissible' => false,
])

@php
    $colorMap = [
        'success' => 'alert-success',
        'danger'  => 'alert-danger',
        'warning' => 'alert-warning',
        'info'    => 'alert-info',
    ];
    $colorClass = $colorMap[$type] ?? 'alert-inf    o';
@endphp

<div class="alert {{ $colorClass }} {{ $dismissible ? 'alert-dismissible fade show' : '' }}" role="alert">
    @if (isset($title) && !empty($title))
        <h4 class="alert-heading">{{ $title }}</h4>
        <hr>
    @endif

    {{ $slot }}

    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @endif
</div>