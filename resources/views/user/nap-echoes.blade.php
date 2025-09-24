@extends('layouts.user.app')

@section('title', 'Nạp Echoes')
@section('content')
    <!-- Hero Banner Section -->
    @if(config_get('echoes_cover_image'))
        <section class="hero-banner">
            <div class="container">
                <div class="hero-banner__wrapper">
                    <img src="{{ config_get('echoes_cover_image') }}" alt="Nạp Echoes" class="hero-banner__img">
                </div>
            </div>
        </section>
    @endif

    <section class="service">
        <div class="container">
            <div class="section-header">
                <h2 class="section__title">Nạp Echoes</h2>
                <p class="section__subtitle">Thông tin và bảng giá</p>
            </div>

            <div class="service__cards">
                <div class="service__card service__card--rules">
                    <div class="service__card-content">
                        {!! $identityText !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

<style>
.hero-banner {
    margin-bottom: 40px;
}

.hero-banner__wrapper {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.hero-banner__img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    display: block;
}

.identity-content {
    line-height: 1.6;
    font-size: 16px;
}

.identity-content h1,
.identity-content h2,
.identity-content h3,
.identity-content h4,
.identity-content h5,
.identity-content h6 {
    margin-top: 1.5em;
    margin-bottom: 0.5em;
    font-weight: bold;
}

.identity-content p {
    margin-bottom: 1em;
}

.identity-content ul,
.identity-content ol {
    margin-bottom: 1em;
    padding-left: 2em;
}

.identity-content blockquote {
    border-left: 4px solid #ddd;
    margin: 1em 0;
    padding-left: 1em;
    font-style: italic;
}

.identity-content code {
    background-color: #f4f4f4;
    padding: 2px 4px;
    border-radius: 3px;
    font-family: monospace;
}

.identity-content pre {
    background-color: #f4f4f4;
    padding: 1em;
    border-radius: 4px;
    overflow-x: auto;
}

.identity-content a {
    color: #007bff;
    text-decoration: none;
}

.identity-content a:hover {
    text-decoration: underline;
}

.identity-content img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
}
</style>
@endsection
