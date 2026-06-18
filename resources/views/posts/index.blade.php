@extends('layouts.app')

@section('title', 'Danh sách bài viết')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">📋 Danh sách bài viết</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">+ Thêm bài viết</a>
</div>

@if ($posts->isEmpty())
    <div class="text-center py-5 text-muted">
        <p>Chưa có bài viết nào.</p>
        <a href="{{ route('posts.create') }}" class="btn btn-outline-primary">
            Tạo bài viết đầu tiên
        </a>
    </div>
@else
    <div class="list-group shadow-sm">
        @foreach ($posts as $post)
            <div class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1 me-3">
                        <h5 class="mb-1">
                            <a href="{{ route('posts.show', $post) }}"
                               class="text-decoration-none text-dark">
                                #{{ $loop->iteration }}. {{ $post->title }}
                            </a>
                        </h5>
                        <p class="mb-1 text-muted small">
                            {{ Str::limit($post->content, 120) }}
                        </p>
                        <small class="text-muted">
                            {{ $post->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="d-flex gap-2 flex-shrink-0">
                        <a href="{{ route('posts.edit', $post) }}"
                           class="btn btn-sm btn-outline-primary">✏️ Sửa</a>

                        {{-- Form xóa --}}
                        <form method="POST"
                              action="{{ route('posts.destroy', $post) }}"
                              onsubmit="return confirm('Bạn có chắc muốn xóa bài viết: {{ $post->title }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                🗑️ Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
@endif
@endsection