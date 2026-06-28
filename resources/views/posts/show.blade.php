@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div style="max-width: 760px; margin: 0 auto;">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('posts.index', ['mine' => 1]) }}">📋 Danh sách</a>
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
            <div class="d-flex gap-2 align-items-center">
                @can('update-post', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-light">✏️ Sửa</a>
                @endcan

                @can('delete-post', $post)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                          onsubmit="return confirm('Xóa bài viết: {{ $post->title }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">🗑️ Xóa</button>
                    </form>
                @endcan

                {{-- SỬA: đổi text-muted thành text-white để nhìn rõ trên nền tối --}}
                @cannot('update-post', $post)
                    <small class="text-white">🔒 Chỉ tác giả có quyền sửa bài viết này</small>
                @endcannot
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
            <a href="{{ route('posts.index', ['mine' => 1]) }}" class="text-muted">
                ← Quay lại danh sách
            </a>
        </div>
    </article>

    {{-- PHẦN BÌNH LUẬN --}}
    <div class="mt-5">
        <h3>💬 Bình luận ({{ $post->comments_count ?? 0 }})</h3>

        @auth
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('posts.comment', $post) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="commentBody" class="form-label">Viết bình luận</label>
                            <textarea
                                id="commentBody"
                                name="body"
                                rows="3"
                                class="form-control @error('body') is-invalid @enderror"
                                placeholder="Nhập bình luận của bạn..."
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <a href="{{ route('login') }}">Đăng nhập</a> để bình luận.
            </div>
        @endauth

        @forelse($post->approvedComments as $comment)
            <div class="card mb-2 shadow-sm" id="comment-{{ $comment->id }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $comment->user->name ?? 'Người dùng ẩn danh' }}</strong>
                            <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        @auth
                            @if (Auth::id() === $comment->user_id || Auth::id() == 1)
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-link text-decoration-none p-0" onclick="editComment({{ $comment->id }})" title="Sửa bình luận">
                                        ✏️
                                    </button>
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="d-inline"
                                          onsubmit="return confirm('Xóa bình luận này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0 text-danger" title="Xóa bình luận">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <div class="comment-body-{{ $comment->id }}">
                        <p class="mb-0 mt-2">{{ $comment->body }}</p>
                    </div>
                    <div class="comment-edit-form-{{ $comment->id }}" style="display: none; margin-top: 10px;">
                        <form method="POST" action="{{ route('comments.update', $comment) }}" class="d-flex gap-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="body" value="{{ $comment->body }}" class="form-control form-control-sm" required>
                            <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="cancelEdit({{ $comment->id }})">Hủy</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-secondary">
                Chưa có bình luận nào. Hãy là người đầu tiên bình luận!
            </div>
        @endforelse
    </div>
</div>

<script>
function editComment(id) {
    document.querySelector('.comment-body-' + id).style.display = 'none';
    document.querySelector('.comment-edit-form-' + id).style.display = 'block';
}
function cancelEdit(id) {
    document.querySelector('.comment-body-' + id).style.display = 'block';
    document.querySelector('.comment-edit-form-' + id).style.display = 'none';
}
</script>
@endsection