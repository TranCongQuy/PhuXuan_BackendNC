@extends('layouts.app')

@section('title', 'Chỉnh sửa: ' . $post->title)

@section('content')
<div class="container mt-4" style="max-width: 760px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>✏️ Chỉnh sửa bài viết</h2>
        <a href="{{ route('posts.index', ['mine' => 1]) }}" class="btn btn-outline-secondary">
            ← Quay lại danh sách
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>⚠ Vui lòng kiểm tra lại:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            {{-- FORM CẬP NHẬT --}}
            <form method="POST" action="{{ route('posts.update', $post) }}" id="updateForm">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="form-label fw-bold">
                        Tiêu đề <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $post->title) }}"
                        class="form-control @error('title') is-invalid @enderror"
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="content" class="form-label fw-bold">
                        Nội dung <span class="text-danger">*</span>
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="8"
                        class="form-control @error('content') is-invalid @enderror"
                    >{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                {{-- Hàng nút bấm (chỉ chứa nút Cập nhật và Hủy) --}}
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <button type="submit" form="updateForm" class="btn btn-success px-4">✅ Cập nhật</button>
                    <a href="{{ route('posts.index', ['mine' => 1]) }}" class="btn btn-light">Hủy</a>
                </div>
            </form>
            {{-- Kết thúc form cập nhật --}}

            {{-- FORM XUẤT BẢN (riêng biệt) --}}
            @if (Auth::id() == 1 && $post->status !== 'published')
                <div class="mt-3 d-flex justify-content-end">
                    <form method="POST" action="{{ route('posts.publish', $post) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">📢 Xuất bản</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection