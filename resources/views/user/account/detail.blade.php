{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')
@section('title', 'Tài khoản #' . $account->id)
@push('css')
<style>
.product { display: grid; grid-template-columns: 1.1fr .9fr; gap: 32px; }
.product-gallery { display: grid; grid-template-columns: 92px 1fr; gap: 16px; align-items: start; grid-template-areas: 'thumbs main'; }
.thumbs { grid-area: thumbs; }
.main-image { grid-area: main; }
.thumbs { display: flex; flex-direction: column; gap: 10px; max-height: 520px; overflow: auto; }
.thumbs img { width: 92px; height: 92px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; cursor: pointer; transition: transform .15s ease; }
.thumbs img:hover { transform: scale(1.02); }
.main-image { width: 100%; border: 1px solid #eee; border-radius: 12px; overflow: hidden; background: #fff; }
.main-image img { width: 100%; height: auto; max-height: 520px; object-fit: contain; display: block; }
.product-summary h1 { font-size: 22px; margin: 0 0 6px; }
.product-price { font-size: 28px; font-weight: 700; color: #e11d48; margin: 8px 0 16px; }
.product-meta { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 12px; margin-bottom: 16px; }
.product-meta .item { background: #f8fafc; border: 1px solid #eef2f7; border-radius: 10px; padding: 10px 12px; font-size: 14px; }
.actions { display: flex; gap: 12px; margin: 18px 0 24px; }
.btn-primary-buy { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: #fff; padding: 14px 22px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; box-shadow: 0 6px 20px rgba(14, 62, 218, 0.35); transition: transform .2s ease, box-shadow .2s ease, background .2s ease; font-weight: 700; font-size: 16px; text-transform: uppercase; }
.btn-primary-buy:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(14, 62, 218, 0.45); }
.btn-primary-buy i { font-size: 18px; }
.btn-outline { border: 1px solid #e5e7eb; color: #111827; padding: 12px 18px; border-radius: 8px; text-decoration: none; }
.tabs { margin-top: 24px; }
.tab-nav { display: flex; gap: 16px; border-bottom: 1px solid #e5e7eb; margin-bottom: 14px; }
.tab-nav a { padding: 10px 0; text-decoration: none; color: #6b7280; border-bottom: 2px solid transparent; }
.tab-nav a.active { color: #111827; border-color: #111827; font-weight: 600; }
.tab-content { font-size: 15px; color: #374151; }
@media (max-width: 1024px){ .product { grid-template-columns: 1fr; } .product-gallery { grid-template-columns: 1fr; grid-template-areas: 'main' 'thumbs'; } .thumbs { flex-direction: row; max-height: unset; } .main-image img { height: auto; } }
</style>
@endpush
@section('content')
<section class="section" style="padding-top: 40px;">
    <div class="container">
        <div class="product">
            <div class="product-gallery">
                <div class="thumbs">
                    @if($account->thumb)
                        <img data-large="{{ asset($account->thumb) }}" src="{{ asset($account->thumb) }}" alt="Thumb #{{ $account->id }}">
                    @endif
                    @foreach($images as $image)
                        <img data-large="{{ asset($image) }}" src="{{ asset($image) }}" alt="Ảnh {{ $loop->iteration }}">
                    @endforeach
                </div>
                <div class="main-image">
                    <a href="{{ $account->thumb ? asset($account->thumb) : (count($images)?asset($images[0]):'#') }}" class="main-image-link">
                        <img id="mainImage" src="{{ $account->thumb ? asset($account->thumb) : (count($images)?asset($images[0]):asset('assets/img/img-placeholder.png')) }}" alt="Tài khoản #{{ $account->id }}">
                    </a>
                </div>
            </div>
            <div class="product-summary">
                <h1 style="color:#fff; text-shadow:0 2px 6px rgba(0,0,0,.35)">Tài khoản #{{ $account->id }}</h1>
                <div class="product-price">{{ number_format($account->price) }} đ</div>
                <div class="product-meta">
                    <div class="item">
                        <div><strong>Hệ điều hành</strong></div>
                        <div style="word-break: break-all; margin-top: 6px;">{{ $account->planet === 'earth' ? 'Android' : 'iOS' }}</div>
                    </div>
                    @if($account->note)
                        <div class="item">
                            <div><strong>Liên kết</strong></div>
                            <div style="word-break: break-all; margin-top: 6px;">{{ $account->note }}</div>
                        </div>
                    @endif
                </div>
                <div class="actions">
                    <button type="button" class="btn-primary-buy" data-open-qr>Mua ngay</button>
                </div>
                
                
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const mainImg = document.getElementById('mainImage');
  const mainLink = document.querySelector('.main-image-link');
  document.querySelectorAll('.thumbs img').forEach(function(el){
    el.addEventListener('click', function(){
      const url = this.getAttribute('data-large') || this.src;
      mainImg.src = url;
      if (mainLink) mainLink.href = url;
    });
  });
  document.querySelectorAll('[data-tab]').forEach(function(t){
    t.addEventListener('click', function(e){
      e.preventDefault();
      document.querySelectorAll('.tab-nav a').forEach(a=>a.classList.remove('active'));
      this.classList.add('active');
      document.querySelectorAll('.tab-content').forEach(c=>c.style.display='none');
      const target = document.querySelector(this.getAttribute('href'));
      if (target) target.style.display='block';
    });
  });
  try { new SimpleLightbox('.main-image a, .detail__images-list a'); } catch(e) {}
  const openBtn = document.querySelector('[data-open-qr]');
  if (openBtn) {
    openBtn.addEventListener('click', function(){
      const modal = document.getElementById('qrModal');
      if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
      }
    });
  }
  document.addEventListener('click', function(e){
    if (e.target.matches('[data-close-qr]') || e.target.closest('[data-close-qr]')) {
      const modal = document.getElementById('qrModal');
      if (modal) { modal.style.display = 'none'; document.body.style.overflow = ''; }
    }
    if (e.target.id === 'qrModal') { e.target.style.display = 'none'; document.body.style.overflow = ''; }
  });
});
</script>
@endpush
@endsection

@push('css')
<style>
.modal { display:none; position: fixed; inset: 0; background: rgba(0,0,0,.6); z-index: 1000; }
.modal-dialog { width: 92vw; max-width: 360px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; }
.modal-header { display:flex; justify-content: space-between; align-items: center; padding: 10px 14px; border-bottom: 1px solid #e5e7eb; }
.modal-body { padding: 12px; }
.modal-footer { padding: 10px 14px; border-top: 1px solid #e5e7eb; text-align: right; }
.qr-img { width: 100%; height: auto; display:block; border-radius: 8px; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const escHandler = function(e){ if (e.key === 'Escape'){ const m=document.getElementById('qrModal'); if(m){m.style.display='none'; document.body.style.overflow='';} } };
  document.addEventListener('keydown', escHandler);
});
</script>
@endpush

@push('modals')
<div id="qrModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-header">
      <h5 class="modal-title">Thanh toán bằng VietQR</h5>
      <button type="button" data-close-qr class="btn btn-sm btn-light">×</button>
    </div>
    <div class="modal-body">
      @if(isset($qrUrl) && $qrUrl)
        <img class="qr-img" src="{{ $qrUrl }}" alt="VietQR">
      @else
        <p>Hiện chưa có tài khoản ngân hàng hoạt động để tạo mã VietQR.</p>
      @endif
      <div style="text-align: center; margin-top: 16px; font-size: 14px; color: #6b7280;">
        Bạn đã thanh toán?
      </div>
    </div>
    <div class="modal-footer" style="display: flex; gap: 12px; justify-content: flex-end;">
      <a href="{{ config_get('contact_admin_url') }}" target="_blank" rel="noopener" class="btn btn-primary" style="background: #111827; border: none; padding: 12px 18px; border-radius: 8px; color: white; text-decoration: none; font-weight: 500;">Liên Hệ Admin</a>
      <button type="button" data-close-qr class="btn" style="border: 1px solid #e5e7eb; color: #111827; padding: 12px 18px; border-radius: 8px; background: #fff; font-weight: 500;">Đóng</button>
    </div>
  </div>
  </div>
</div>
@endpush
