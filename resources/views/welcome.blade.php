@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
            🏠 Chào mừng đến Phú Xuân Blog!
        </h1>
        <p class="mt-4 text-xl text-gray-500">
            Ứng dụng demo học Laravel – Đại học Phú Xuân
        </p>
    </div>

    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Card 1: Blog -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <div class="px-6 py-8">
                <div class="text-4xl mb-4">📝</div>
                <h3 class="text-xl font-semibold text-gray-900">Blog</h3>
                <p class="mt-2 text-gray-500">Xem các bài viết mới nhất về Laravel.</p>
                <a href="{{ route('posts.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                    Xem ngay
                </a>
            </div>
        </div>

        <!-- Card 2: Cửa hàng -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <div class="px-6 py-8">
                <div class="text-4xl mb-4">🛒</div>
                <h3 class="text-xl font-semibold text-gray-900">Cửa hàng</h3>
                <p class="mt-2 text-gray-500">Khám phá sản phẩm trong cửa hàng online.</p>
                <a href="{{ route('shop.products') }}" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                    Mua sắm
                </a>
            </div>
        </div>

        <!-- Card 3: Về chúng tôi -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <div class="px-6 py-8">
                <div class="text-4xl mb-4">ℹ️</div>
                <h3 class="text-xl font-semibold text-gray-900">Về chúng tôi</h3>
                <p class="mt-2 text-gray-500">Tìm hiểu thêm về nhóm phát triển.</p>
                <a href="{{ route('about') }}" class="mt-4 inline-block bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                    Xem thêm
                </a>
            </div>
        </div>
    </div>

    <!-- Auth Links -->
    <div class="mt-12 text-center">
        @auth
            <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200">
                Vào Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200">
                Đăng nhập
            </a>
            <a href="{{ route('register') }}" class="ml-4 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200">
                Đăng ký
            </a>
        @endauth
    </div>
</div>
@endsection