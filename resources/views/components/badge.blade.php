@props(['status' => 'draft'])

@php
    $config = [
        'published' => ['class' => 'bg-success', 'label' => 'Đã xuất bản'],
        'draft'     => ['class' => 'bg-warning text-dark', 'label' => 'Bản nháp'],
        'archived'  => ['class' => 'bg-secondary', 'label' => 'Lưu trữ'],
    ];

    if (isset($config[$status])) {
        $class = $config[$status]['class'];
        $label = $config[$status]['label'];
    } else {
        $class = 'bg-light text-dark';
        $label = '? ' . $status;
    }
@endphp

<span class="badge {{ $class }}">
    {{ $label }}
</span>