{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')
@section('title', $title)
@section('content')
    <x-hero-header title="DỊCH VỤ GAME" description="Danh sách các " />

    <section class="menu">
        <div class="container">
            <div class="category__list">
                @if ($services->count() > 0)
                    @foreach ($services as $service)
                        @if ($service->active)
                            @php
                                $serviceSlug = $service->slug ?? '';
                                $serviceName = $service->name ?? '';
                            @endphp
                            @if (empty($serviceSlug) || empty($serviceName))
                                @continue
                            @endif
                            @if($serviceSlug == 'cay-thue')
                                <a href="{{ route('user.cay-thue') }}" class="category__item">
                            @elseif($serviceSlug == 'cho-thue')
                                <a href="{{ route('user.cho-thue') }}" class="category__item">
                            @else
                                <a href="{{ route('service.show', ['slug' => $serviceSlug]) }}" class="category__item">
                            @endif
                                <img src="{{ $service->thumbnail }}?v={{ $service->updated_at?->timestamp }}" alt="{{ $serviceName }}" class="category__img" />
                                <h2 class="category__title">{{ strtoupper((string) $serviceName) }}</h2>
                            </a>
                        @endif
                    @endforeach
                @else
                    <div class="no-results">
                        <div class="no-results__content">
                            <i class="fas fa-exclamation-circle no-results__icon"></i>
                            <h2 class="no-results__title">Không tìm thấy dịch vụ!</h2>
                            <p class="no-results__message">Hiện tại không có dịch vụ game nào.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
