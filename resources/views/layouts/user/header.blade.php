{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<!-- Announcement -->
<header class="announcement">
    <div class="container row">
        <div class="announcement__media">
            <a class="media__facebook" href="{{ config_get('facebook', '#') }}" target="_blank"><i class="fa-brands fa-facebook"></i></a>
        </div>
        <div class="announcement__hotline">Hotline: <a href="tel:{{ config_get('phone') }}">{{ preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1.$2.$3', config_get('phone')) }}</a>
        </div>
    </div>
</header>

<!-- Nav -->
<nav class="nav">
    <div class="container row">
        <a href="/" style="display: flex; align-items: center">
            <img src="{{ config_get('site_logo') }}" alt="{{ config_get('site_name') }}" class="nav__logo" />
        </a>
        <div class="nav__menu">
            <a href="/" class="text menu__item {{ request()->is('/') ? 'active' : '' }}">Trang chủ</a>
            
            <a href="{{ route('service.show-all') }}"
                class="text menu__item {{ request()->routeIs('service.*') ? 'active' : '' }}">Dịch vụ</a>

            


            @if (Auth::check() && Auth()->user()->role == 'admin')
                <a href="{{ route('admin.index') }}" target="_blank" class="text menu__item">Quản Lí</a>
            @endif
        </div>
        <button class="menu-toggle" aria-label="Toggle Menu">
            <i class="fas fa-bars"></i>
        </button>
        <div class="nav__action">
            @guest
                <a href="{{ route('login') }}" class="text action__link"><i class="fa-solid fa-user"></i> Đăng nhập</a>
                <a href="{{ route('register') }}" class="text action__link action__link--primary"><i
                        class="fa-solid fa-key"></i> Đăng ký</a>
            @else
                <a href="{{ route('profile.index') }}" class="text"><i class="fa-solid fa-user"></i>
                    {{ Auth::user()->username }}</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="text action__link action__link--primary">
                        <i class="fa-solid fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            @endguest
        </div>
    </div>
</nav>
