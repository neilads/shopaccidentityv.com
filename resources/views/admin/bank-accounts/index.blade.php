@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Quản lý tài khoản ngân hàng</h4>
                    <h6>Xem và quản lý các tài khoản ngân hàng</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.bank-accounts.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">
                        Thêm tài khoản mới
                    </a>
                </div>
            </div>


            @if (session('success'))
                <x-alert-admin type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert-admin type="danger" :message="session('error')" />
            @endif

            

            <div class="card">
                <style>
                    .switch { position: relative; display: inline-block; width: 46px; height: 24px; }
                    .switch input { opacity: 0; width: 0; height: 0; }
                    .sliders { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .2s; }
                    .sliders:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .2s; }
                    input:checked + .sliders { background-color: #22c55e; }
                    input:focus + .sliders { box-shadow: 0 0 1px #22c55e; }
                    input:checked + .sliders:before { transform: translateX(22px); }
                    .sliders.round { border-radius: 24px; }
                    .sliders.round:before { border-radius: 50%; }
                </style>
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                                </a>
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>
                                        <input type="search" class="form-control form-control-sm"
                                            placeholder="Tìm kiếm...">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ngân hàng</th>
                                    <th>Số tài khoản</th>
                                    <th>Trạng thái</th>
                                    <th class="text-end">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankAccounts as $key => $account)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $account->bank_name }}</td>
                                        <td>{{ $account->account_number }}</td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="toggle-active" data-id="{{ $account->id }}" {{ $account->is_active ? 'checked' : '' }}>
                                                <span class="sliders round"></span>
                                            </label>
                                        </td>
                                        <td class="text-end">
                                            <a class="me-3" href="{{ route('admin.bank-accounts.edit', $account->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3 confirm-delete" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $account->id }}">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal-confirm-delete
        message=" Bạn có chắc chắn muốn xóa tài khoản ngân hàng này không? Tất cả dữ liệu có liên quan đến nó sẽ
                    biến mất khỏi hệ thống!" />
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let accountId;

            // Lưu ID tài khoản khi click nút xóa
            $('.confirm-delete').on('click', function() {
                accountId = $(this).data('id');
            });

            // Xử lý sự kiện click nút xác nhận xóa
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: '/admin/bank-accounts/delete/' + accountId,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        if (response.status) {
                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.message ||
                                    'Đã xóa tài khoản ngân hàng thành công',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Reload trang
                                window.location.reload();
                            });
                        } else {
                            // Hiển thị thông báo lỗi
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: response.message ||
                                    'Có lỗi xảy ra khi xóa tài khoản ngân hàng',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi xóa tài khoản ngân hàng',
                        });
                    }
                });
            });

            $('.toggle-active').on('change', function(e) {
                const id = $(this).data('id');
                $.ajax({
                    url: '{{ url('/admin/bank-accounts/toggle') }}/' + id,
                    type: 'POST',
                    dataType: 'json',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.status) {
                            $('.toggle-active').each(function() {
                                if ($(this).data('id') != id) $(this).prop('checked', false);
                            });
                        } else {
                            $(e.target).prop('checked', !$(e.target).prop('checked'));
                            Swal.fire({ icon: 'error', title: 'Lỗi!', text: response.message || 'Không thể cập nhật trạng thái' });
                        }
                    },
                    error: function() {
                        $(e.target).prop('checked', !$(e.target).prop('checked'));
                        Swal.fire({ icon: 'error', title: 'Lỗi!', text: 'Không thể cập nhật trạng thái' });
                    }
                });
            });
        });
    </script>
@endpush
