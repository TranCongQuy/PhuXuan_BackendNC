@extends('layouts.app')

@section('title', 'Bài viết đã xóa')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🗑️ Bài viết đã xóa</h2>
        {{-- SỬA: về danh sách bài viết của user (mine=1) --}}
        <a href="{{ route('posts.index', ['mine' => 1]) }}" class="btn btn-outline-secondary">
            ← Quay lại danh sách
        </a>
    </div>

    @forelse ($posts as $post)
        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
            <div>
                <strong>{{ $post->title }}</strong>
                <div class="text-muted small">
                    🕒 Đã xóa lúc: {{ $post->deleted_at->format('d/m/Y H:i') }}
                </div>
            </div>
            <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="btn btn-sm btn-outline-success" onclick="return confirm('Khôi phục bài viết: {{ $post->title }}?')">
                    🔄 Khôi phục
                </button>
            </form>
        </div>
    @empty
        <div class="text-center py-5 text-muted">
            <p>📭 Không có bài viết nào trong thùng rác.</p>
            {{-- SỬA: về danh sách bài viết của user (mine=1) --}}
            <a href="{{ route('posts.index', ['mine' => 1]) }}" class="btn btn-primary btn-sm">
                Về danh sách bài viết
            </a>
        </div>
    @endforelse

    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection