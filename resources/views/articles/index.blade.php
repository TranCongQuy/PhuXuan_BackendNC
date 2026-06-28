@extends('layouts.app')

@section('title', 'Danh sách bài viết - Articles')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📰 Danh sách bài viết</h2>
        <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-sm">Xóa lọc</a>
    </div>

    {{-- Bộ lọc theo category (query string) --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('articles.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">📂 Danh mục</label>
                    <select name="category" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">🔍 Lọc</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Danh sách bài viết --}}
    @if(empty($articles))
        <div class="alert alert-info">Không có bài viết nào.</div>
    @else
        @foreach($articles as $article)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $article['title'] }}</h5>
                    <p class="card-text">{{ $article['content'] }}</p>
                    <span class="badge bg-primary">{{ $article['category'] }}</span>
                    <span class="text-muted small ms-2">✍️ {{ $article['author'] ?? 'Ẩn danh' }}</span>
                </div>
            </div>
        @endforeach
        <p class="text-muted text-center">Tổng cộng: <strong>{{ count($articles) }}</strong> bài viết</p>
    @endif
</div>
@endsection