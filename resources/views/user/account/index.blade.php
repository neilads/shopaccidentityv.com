@extends('layouts.user.app')
@section('title', $title)
@section('content')
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">{{ $title }}</h2>
            </header>
            <div class="category__list" style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
                @forelse ($accounts as $account)
                    <a href="{{ route('account.show', ['id' => $account->id]) }}" class="category__item">
                        <img src="{{ $account->thumb }}" alt="acc" class="category__img" />
                        <h2 class="category__title">{{ number_format($account->price) }}đ</h2>
                        <div class="category__stats">
                            <span class="badge">{{ $account->planet == 'earth' ? 'Android' : 'iOS' }}</span>
                        </div>
                        <p class="category__action">XEM CHI TIẾT</p>
                    </a>
                @empty
                    <div>Hiện chưa có tài khoản nào đang bán</div>
                @endforelse
            </div>

            <div class="pagination" style="margin-top:16px;">
                {{ $accounts->links() }}
            </div>
        </div>
    </section>
@endsection

