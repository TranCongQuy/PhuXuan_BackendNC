<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Phú Xuân Blog') | Phú Xuân Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        .alert { border-radius: 8px; }
        .alert-success { border-left: 4px solid #16a34a; }
        .alert-danger { border-left: 4px solid #dc2626; }
        .alert-warning { border-left: 4px solid #d97706; }
        .alert-info { border-left: 4px solid #0891b2; }
    </style>
</head>
<body class="bg-light">
    {{-- NAVBAR --}}
    @include('partials.navbar')

    <div class="container mt-4">
        {{-- FLASH MESSAGES (CHỈ HIỂN THỊ Ở ĐÂY) --}}
        @foreach (['success', 'error', 'warning', 'info'] as $type)
            @if (session($type))
                <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                    @if ($type === 'success') ✅
                    @elseif ($type === 'error') ❌
                    @elseif ($type === 'warning') ⚠️
                    @else ℹ️ @endif
                    {{ session($type) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach

        {{-- NỘI DUNG CHÍNH --}}
        @yield('content')
    </div>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- BOOTSTRAP 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>

    {{-- AUTO-DISMISS FLASH SAU 5 GIÂY --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
                setTimeout(function () {
                    var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    if (bsAlert) bsAlert.close();
                }, 5000);
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
                        var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                        if (bsAlert) bsAlert.close();
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>