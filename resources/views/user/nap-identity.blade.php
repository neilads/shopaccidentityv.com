@extends('layouts.user.app')

@section('title', 'Nạp Identity V')
@section('content')
    <section class="service">
        <div class="container">
            <div class="section-header">
                <h2 class="section__title">Nạp Identity V</h2>
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
@endsection

@extends('layouts.user.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Nạp Identity V</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="identity-content">
                    {!! $identityText !!}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
