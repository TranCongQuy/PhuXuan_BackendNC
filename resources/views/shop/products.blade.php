@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🛍️ Sản phẩm</h2>
        <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary btn-sm">Xóa lọc</a>
    </div>

    {{-- Bộ lọc theo category --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('shop.products') }}" class="row g-3 align-items-end">
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

    {{-- Danh sách sản phẩm --}}
    @if(empty($products))
        <div class="alert alert-info">Không có sản phẩm nào.</div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text text-muted">{{ $product['description'] }}</p>
                            <p class="fw-bold text-primary">{{ $product['price'] }}</p>
                            <span class="badge bg-secondary">{{ $product['category'] }}</span>
                            <div class="mt-3">
                                <a href="#" class="btn btn-success btn-sm w-100">🛒 Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="text-muted text-center mt-4">Tổng cộng: <strong>{{ count($products) }}</strong> sản phẩm</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('shop.cart') }}" class="btn btn-success">🛍️ Xem giỏ hàng</a>
    </div>
</div>
@endsection