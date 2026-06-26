@extends('layouts.app')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h3">✏️ Chỉnh sửa bài viết</h1>
            <p class="text-muted">Trang này đang được xây dựng.</p>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">← Quay lại danh sách</a>
        </div>
    </div>
@endsection