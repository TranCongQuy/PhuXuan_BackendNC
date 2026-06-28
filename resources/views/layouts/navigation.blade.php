<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1B2A4A;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Phú Xuân Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            {{-- Menu chính (đẩy sang phải) --}}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" 
                       href="{{ route('about') }}">Giới thiệu</a>
                </li>
                
                {{-- Link Bài viết: nếu chưa login → mở modal --}}
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posts.*') || request()->routeIs('categories.*') || request()->routeIs('articles.*') ? 'active' : '' }}" 
                           href="{{ route('posts.index') }}">Bài viết</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginRequiredModal">
                            Bài viết
                        </a>
                    </li>
                @endauth

                {{-- Link Cửa hàng: nếu chưa login → mở modal --}}
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}" 
                           href="{{ route('shop.products') }}">Cửa hàng</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginRequiredModal">
                            Cửa hàng
                        </a>
                    </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" 
                       href="{{ route('contact') }}">Liên hệ</a>
                </li>
            </ul>

            {{-- Auth (phải) --}}
            <ul class="navbar-nav ms-2">
                @auth
              <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
        👤 {{ Auth::user()->name }}
        {{-- BADGE ROLE --}}
        @php
            $role = Auth::user()->role ?? 'user';
        @endphp
        <span class="badge 
            @if($role === 'admin') bg-danger 
            @elseif($role === 'editor') bg-warning text-dark 
            @else bg-secondary 
            @endif
            ms-1">
            {{ ucfirst($role) }}
        </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('dashboard') }}">📊 Dashboard</a></li>
        <li><a class="dropdown-item" href="{{ route('posts.create') }}">✏️ Viết bài mới</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">🚪 Đăng xuất</button>
            </form>
        </li>
    </ul>
</li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">🔑 Đăng nhập</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">📝 Đăng ký</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>