@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-4">
        {{-- Card 1: Bài viết --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📝 Bài viết</h5>
                    @php
                        $userId = Auth::id();
                        // Luôn lấy số bài viết của user hiện tại
                        $postCount = \App\Models\Post::where('user_id', $userId)->count();
                        $label = 'Bài viết của bạn';
                    @endphp
                    <p class="card-text">
                        <span class="display-6">{{ $postCount }}</span><br>
                        <span class="text-muted small">{{ $label }}</span>
                    </p>
                    <a href="{{ route('posts.index', ['mine' => 1]) }}" class="btn btn-primary btn-sm">Xem tất cả</a>
                </div>
            </div>
        </div>

        {{-- Card 2: Viết bài mới --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">✏️ Viết bài mới</h5>
                    <p class="card-text">Tạo bài viết mới</p>
                    <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">Viết bài</a>
                </div>
            </div>
        </div>

        {{-- Card 3: Thông tin --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">👤 Thông tin</h5>
                    <p class="card-text">{{ Auth::user()->email }}</p>
                    <p class="text-muted small">
                        @if(Auth::id() == 1)
                            <span class="badge bg-danger">🔑 Admin</span>
                        @else
                            <span class="badge bg-secondary">👤 User</span>
                        @endif
                    </p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">🚪 Đăng xuất</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection