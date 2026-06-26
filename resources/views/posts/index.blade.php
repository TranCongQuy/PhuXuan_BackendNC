@extends('layouts.app')

@section('title', 'Danh sách bài viết')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">📋 Danh sách bài viết</h2>
    <div>
        <a href="{{ route('posts.trashed') }}" class="btn btn-outline-secondary me-2">
            🗑️ Thùng rác
        </a>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            + Thêm bài viết
        </a>
    </div>
</div>

{{-- FORM TÌM KIẾM VÀ FILTER --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('posts.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">🔍 Tìm kiếm</label>
                <input type="text" name="search" class="form-control"
                       placeholder="Nhập từ khóa..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">📂 Danh mục</label>
                <select name="category_id" class="form-select">
                    <option value="">Tất cả</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">📅 Sắp xếp</label>
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">🔍 Tìm</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary w-100">🗑️ Xóa filter</a>
            </div>
        </form>
    </div>
</div>

{{-- DANH SÁCH BÀI VIẾT --}}
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

                        {{-- Hiển thị excerpt --}}
                        <p class="mb-1 text-muted small">
                            {{ $post->excerpt ?? Str::limit($post->content, 120) }}
                        </p>

                        {{-- Meta: tác giả, ngày, reading_time, comments --}}
                        <div class="d-flex flex-wrap gap-3 text-muted small">
                            <span>✍️ {{ $post->user->name ?? 'Ẩn danh' }}</span>
                            <span>📅 {{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Chưa xuất bản' }}</span>
                            <span>⏱️ {{ $post->reading_time }}</span> {{-- Accessor --}}
                            <span>💬 {{ $post->comments_count }} bình luận</span>
                            <span>👁️ {{ number_format($post->views_count ?? 0) }} lượt xem</span>
                        </div>

                        {{-- Tags --}}
                        @if($post->tags->isNotEmpty())
                            <div class="mt-1">
                                @foreach($post->tags as $tag)
                                    <span class="badge bg-secondary me-1">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="d-flex gap-2 flex-shrink-0">
                        <a href="{{ route('posts.edit', $post) }}"
                           class="btn btn-sm btn-outline-primary">✏️ Sửa</a>

                        <form method="POST"
                              action="{{ route('posts.destroy', $post) }}"
                              onsubmit="return confirm('Bạn có chắc muốn xóa bài viết: {{ $post->title }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- PHÂN TRANG --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
@endif
@endsection