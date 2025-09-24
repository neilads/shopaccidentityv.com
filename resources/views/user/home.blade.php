{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')
@section('title', 'Trang chủ')
@section('content')
    <!-- Hero Section with Banner and Top Nạp -->
    <div class="container">
        <div class="hero-wrapper">
            <!-- Banner -->
            <div class="hero-banner">
                <a href="{{ route('home') }}">
                    <img src="{{ config_get('site_banner') }}" alt="{{ config_get('site_description') }}"
                        class="hero-banner__img">
                </a>
            </div>

        </div>
    </div>

    <!-- Thông báo và Giao dịch gần đây -->
    <div class="container">
        @if (!empty(config_get('home_notification')))
            <!-- Thông báo -->
            <div class="service__alert service__alert--success">
                <i class="fas fa-info-circle"></i>
                <div class="service__alert-content">
                    <p>{{ config_get('home_notification') }}</p>
                </div>
                <button class="service__alert-close">&times;</button>
            </div>
        @endif

        
    </div>

    

    <!-- Acc Identity V Mới Về -->
    <section class="menu menu--accounts">
        <div class="container">
            <header class="menu__header menu__header--with-action">
                <h2 class="menu__header__title">Acc Identity V Mới Về</h2>
                <a href="{{ url('/account/all') }}" class="menu__header__link">Xem tất cả</a>
            </header>
            <div class="category__list category__list--products">
                @foreach ($latestAccounts as $account)
                    <a href="{{ route('account.show', ['id' => $account->id]) }}" class="category__item">
                        <div class="category__media">
                            <img src="{{ $account->thumb }}" alt="acc" class="category__img" />
                        </div>
                        <h2 class="category__title">{{ number_format($account->price) }}đ</h2>
                        <div class="category__stats">
                            <span class="badge">{{ $account->planet == 'earth' ? 'Android' : 'iOS' }}</span>
                        </div>
                        @if(!empty($account->note))
                            <div class="category__desc">{{ $account->note }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Menu mục dịch vụ game -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">Dịch Vụ Game</h2>
            </header>
            <div class="category__list category__list--products">
                @foreach ($services->take(3) as $service)
                    @if ($service->active)
                        @if($service->slug == 'cay-thue')
                            <a href="{{ route('user.cay-thue') }}" class="category__item">
                        @elseif($service->slug == 'cho-thue')
                            <a href="{{ route('user.cho-thue') }}" class="category__item">
                        @else
                            <a href="{{ route('service.show', ['slug' => $service->slug]) }}" class="category__item">
                        @endif
                            <div class="category__media">
                                @if(!empty($service->thumbnail))
                                    <img src="{{ $service->thumbnail }}?v={{ $service->updated_at?->timestamp }}" alt="{{ $service->name }}" class="category__img" />
                                @else
                                    <div class="category__img category__img--placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <h2 class="category__title">{{ $service->name }}</h2>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    

    

    <!-- Welcome Modal HTML -->
    @if (config_get('welcome_modal', false))
        <div id="welcomeModal" class="welcome-modal-overlay" style="display: none;">
            <div class="welcome-modal">
                <div class="welcome-modal__header">
                    <h3 class="welcome-modal__title">Thông báo</h3>
                    <button class="welcome-modal__close">&times;</button>
                </div>
                <div class="welcome-modal__body">
                    <img src="{{ config_get('site_logo') }}" alt="{{ config_get('site_description') }}"
                        class="welcome-modal__icon">

                    <p>Chào mừng bạn đến với <b>{{ config_get('site_name') }}</b>!</p>
                    <p>{{ config_get('site_description') }}</p>
                    <div class="welcome-modal__feature-list">
                        @foreach ($notifications as $notification)
                            <div class="welcome-modal__feature-item">
                                <div class="welcome-modal__feature-icon">
                                    <i class="fas {{ $notification->class_favicon }}"></i>
                                </div>
                                <div class="welcome-modal__feature-text">
                                    {{ $notification->content }}
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="welcome-modal__footer">
                    <button class="welcome-modal__btn" id="welcomeModalBtn">
                        <i class="fas fa-rocket"></i> Bắt đầu ngay
                    </button>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('styles')
    <style>
        .service-card__thumb {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            border-radius: 12px;
            overflow: hidden;
            background: #f3f4f6;
        }

        .service-card__thumb img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .service-card__title {
            margin-top: 10px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
        }

        .service-card__placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            color: #9ca3af;
        }

        .service-card__placeholder-icon {
            font-size: 2rem;
        }

        .category__stats {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 10px 20px;
        }

        .recent-transactions__marquee {
            overflow: hidden;
            position: relative;
            height: 150px;
        }

        .recent-transactions__list {
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-50%);
            }
        }

        .recent-transactions__list:hover {
            animation-play-state: paused;
        }

        .recent-transactions__item {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .recent-transactions__username {
            font-weight: bold;
            color: #ffd700;
        }

        .recent-transactions__time {
            color: #aaa;
            font-size: 0.9em;
            margin-left: 5px;
        }

        .recent-transactions__amount {
            color: #4caf50;
            font-weight: bold;
            margin-left: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý đóng thông báo
            const alertCloseBtn = document.querySelector('.service__alert-close');
            if (alertCloseBtn) {
                alertCloseBtn.addEventListener('click', function() {
                    const alert = this.closest('.service__alert');
                    if (alert) {
                        alert.style.display = 'none';
                    }
                });
            }

            // Welcome Modal functionality
            const welcomeModal = document.getElementById('welcomeModal');

            if (welcomeModal) {
                const welcomeModalClose = document.querySelector('.welcome-modal__close');
                const welcomeModalBtn = document.getElementById('welcomeModalBtn');

                // Luôn hiển thị modal khi trang được tải
                setTimeout(() => {
                    welcomeModal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }, 500);

                // Close modal event handlers
                if (welcomeModalClose) {
                    welcomeModalClose.addEventListener('click', closeWelcomeModal);
                }

                if (welcomeModalBtn) {
                    welcomeModalBtn.addEventListener('click', closeWelcomeModal);
                }

                // Close when clicking outside modal
                welcomeModal.addEventListener('click', function(e) {
                    if (e.target === welcomeModal) {
                        closeWelcomeModal();
                    }
                });

                // Close with ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && welcomeModal.style.display === 'flex') {
                        closeWelcomeModal();
                    }
                });

                function closeWelcomeModal() {
                    welcomeModal.style.opacity = '0';
                    setTimeout(() => {
                        welcomeModal.style.display = 'none';
                        welcomeModal.style.opacity = '1';
                        document.body.style.overflow = '';
                    }, 300);
                }
            }
        });
    </script>
@endpush
