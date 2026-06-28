@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h2>🛍️ Giỏ hàng</h2>
    <div class="alert alert-info">
        Hiện chưa có sản phẩm trong giỏ hàng.
    </div>
    <a href="{{ route('shop.products') }}" class="btn btn-secondary">🛒 Tiếp tục mua sắm</a>
</div>
@endsection