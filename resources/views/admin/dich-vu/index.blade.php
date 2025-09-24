@extends('layouts.admin.app')

@section('title', 'Dịch Vụ')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Quản lý dịch vụ</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget">
                            <div class="dash-widgetimg">
                                <span><i class="fas fa-gamepad"></i></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>Cày Thuê</h5>
                                <h6>Dịch vụ cày thuê game</h6>
                                <a href="{{ route('admin.dich-vu.cay-thue') }}" class="btn btn-primary">Quản lý</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget">
                            <div class="dash-widgetimg">
                                <span><i class="fas fa-share-alt"></i></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>Cho Thuê</h5>
                                <h6>Dịch vụ cho thuê tài khoản</h6>
                                <a href="{{ route('admin.dich-vu.cho-thue') }}" class="btn btn-primary">Quản lý</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget">
                            <div class="dash-widgetimg">
                                <span><i class="fas fa-credit-card"></i></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>Nạp Echoes</h5>
                                <h6>Dịch vụ nạp Echoes</h6>
                                <a href="{{ route('admin.dich-vu.nap-identity') }}" class="btn btn-primary">Quản lý</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection