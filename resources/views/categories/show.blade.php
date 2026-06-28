@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('categories.index') }}">📂 Danh mục</a>
            </li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $category->name }}</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            ← Quay lại danh mục
        </a>
    </div>

    @if($category->description)
        <p class="text-muted">{{ $category->description }}</p>
    @endif

    @if($posts->isEmpty())
        <div class="alert alert-info">Chưa có bài viết nào trong danh mục này.</div>
    @else
        @foreach($posts as $post)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                            {{ $post->title }}
                        </a>
                    </h5>
                    <p class="card-text text-muted small">
                        ✍️ {{ $post->user->name ?? 'Ẩn danh' }} · 
                        📅 {{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Chưa xuất bản' }}
                    </p>
                    <p>{{ Str::limit($post->content, 150) }}</p>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection