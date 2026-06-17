@extends('layouts.app')

@section('title', 'Danh sách bài viết')

@section('content')
    <h1 class="mb-4">📝 Danh sách bài viết</h1>
    <p>Tổng số: <strong>{{ $posts->count() }}</strong> bài viết</p>
    <hr>

    @forelse($posts as $post)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">s
                <h5 class="card-title">
                    #{{ $loop->iteration }}. {{ $post->title }}
                </h5>
                <p class="card-text">{{ Str::limit($post->body, 100) }}</p>
                <p class="text-muted small">
                    ✍ {{ $post->author }} · 
                    📅 {{ $post->created_at->format('d/m/Y') }}
                </p>
                @if($post->status === 'published')
                    <span class="badge bg-success">Đã xuất bản</span>
                @elseif($post->status === 'draft')
                    <span class="badge bg-warning text-dark">Bản nháp</span>
                @else
                    <span class="badge bg-secondary">Không xác định</span>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info">Chưa có bài viết nào.</div>
    @endforelse

    @if($posts->count() > 0)
        <p class="text-center text-muted small mt-3">
            — Đã hiển thị tất cả {{ $posts->count() }} bài viết —
        </p>
    @endif
@endsection