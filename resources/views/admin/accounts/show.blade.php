@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chi tiết tài khoản game</h4>
                    <h6>Thông tin chi tiết tài khoản game</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.accounts.edit', $account->id) }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                        Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.accounts.index') }}" class="btn btn-cancel">
                        <img src="{{ asset('assets/img/icons/back.svg') }}" alt="img">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Thông tin tài khoản</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>ID:</strong></label>
                                        <p>{{ $account->id }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Trạng thái:</strong></label>
                                        <p>
                                            @if($account->status == 'available')
                                                <span class="badge bg-success">Có sẵn</span>
                                            @elseif($account->status == 'sold')
                                                <span class="badge bg-danger">Đã bán</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($account->status) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Giá:</strong></label>
                                        <p>{{ number_format($account->price) }} VNĐ</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Hành tinh:</strong></label>
                                        <p>
                                            @if($account->planet == 'earth')
                                                <span class="badge bg-primary">Android</span>
                                            @elseif($account->planet == 'namek')
                                                <span class="badge bg-info">iOS</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($account->planet) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Máy chủ:</strong></label>
                                        <p>{{ $account->server }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Loại đăng ký:</strong></label>
                                        <p>{{ $account->registration_type == 'virtual' ? 'Ảo' : 'Thật' }}</p>
                                    </div>
                                </div>
                                @if($account->note)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label><strong>Ghi chú:</strong></label>
                                        <p>{{ $account->note }}</p>
                                    </div>
                                </div>
                                @endif
                                @if($account->buyer)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label><strong>Người mua:</strong></label>
                                        <p>{{ $account->buyer->username }} ({{ $account->buyer->email }})</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Ảnh đại diện</h5>
                        </div>
                        <div class="card-body text-center">
                            @if($account->thumb)
                                <img src="{{ asset($account->thumb) }}" alt="Ảnh đại diện" 
                                     class="img-fluid" style="max-width: 100%; max-height: 300px; object-fit: cover;">
                            @else
                                <div class="text-muted">
                                    <i class="fas fa-image fa-3x mb-3"></i>
                                    <p>Chưa có ảnh đại diện</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($account->images)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title">Ảnh chi tiết</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach (json_decode($account->images) as $image)
                                    <div class="col-6 mb-3">
                                        <img src="{{ asset($image) }}" alt="Ảnh chi tiết" 
                                             class="img-fluid" style="max-width: 100%; max-height: 150px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
