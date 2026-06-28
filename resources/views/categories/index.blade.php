@extends('layouts.app')

@section('title', 'Danh mục bài viết')

@section('content')
<div class="container">
    <h2 class="mb-4">📂 Danh mục bài viết</h2>

    @if($categories->isEmpty())
        <div class="alert alert-info">Chưa có danh mục nào.</div>
    @else
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text text-muted small">
                                {{ $category->description ?? 'Không có mô tả' }}
                            </p>
                            <p class="text-muted small">
                                📝 {{ $category->posts()->count() }} bài viết
                            </p>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-primary btn-sm">
                                Xem bài viết →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection