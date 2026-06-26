 @extends('layouts.app')

@section('title', $post->title)

@section('content')
<div style="max-width: 760px; margin: 0 auto;">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('posts.index') }}">📋 Danh sách</a>
            </li>
            <li class="breadcrumb-item active">
                {{ Str::limit($post->title, 40) }}
            </li>
        </ol>
    </nav>

    <article class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center py-3"
             style="background:#1B2A4A;">
            <h4 class="mb-0 text-white">{{ $post->title }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('posts.edit', $post) }}"
                   class="btn btn-sm btn-light">✏️ Sửa</a>
                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                      onsubmit="return confirm('Xóa bài viết: {{ $post->title }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">🗑️ Xóa</button>
                </form>
            </div>
        </div>
        <div class="card-body p-4">
            <p class="text-muted small mb-4">
                📅 Tạo lúc {{ $post->created_at->format('d/m/Y H:i') }}
                @if ($post->updated_at != $post->created_at)
                    - Cập nhật {{ $post->updated_at->diffForHumans() }}
                @endif
            </p>
            <div style="line-height:1.8; white-space:pre-wrap;">
                {{ $post->content }}
            </div>

            {{-- ✅ HIỂN THỊ TAGS (Lab 2) --}}
            @if($post->tags->isNotEmpty())
                <div class="mt-3">
                    <strong>🏷️ Tags:</strong>
                    @foreach($post->tags as $tag)
                        <span class="badge bg-info text-dark me-1">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('posts.index') }}" class="text-muted">
                ← Quay lại danh sách
            </a>
        </div>
    </article>

    {{-- PHẦN BÌNH LUẬN (Lab 1) --}}
    <div class="mt-5">
        <h3>💬 Bình luận ({{ $post->comments_count ?? 0 }})</h3>

        @forelse($post->approvedComments as $comment)
            <div class="card mb-2 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $comment->user->name ?? 'Người dùng ẩn danh' }}</strong>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-0 mt-2">{{ $comment->body }}</p>
                </div>
            </div>
        @empty
            <div class="alert alert-secondary">
                Chưa có bình luận nào. Hãy là người đầu tiên bình luận!
            </div>
        @endforelse
    </div>
</div>
@endsection