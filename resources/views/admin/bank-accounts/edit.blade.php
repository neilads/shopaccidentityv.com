@extends('layouts.admin.app')
@section('title', $title)

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa tài khoản ngân hàng</h4>
                    <h6>Cập nhật thông tin tài khoản ngân hàng</h6>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.bank-accounts.update', $bankAccount->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên ngân hàng <span class="text-danger">*</span></label>
                                    <select name="bank_name" id="bankSelect" class="form-control @error('bank_name') is-invalid @enderror">
                                        <option value="">-- Đang tải danh sách ngân hàng --</option>
                                    </select>
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_number"
                                        value="{{ old('account_number', $bankAccount->account_number) }}"
                                        class="form-control @error('account_number') is-invalid @enderror"
                                        placeholder="Nhập số tài khoản">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_name" value="{{ old('account_name', $bankAccount->account_name) }}"
                                        class="form-control @error('account_name') is-invalid @enderror" placeholder="Nhập tên tài khoản">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            
                            
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-cancel">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bankSelect = document.getElementById('bankSelect');
    const currentBankName = '{{ old("bank_name", $bankAccount->bank_name) }}';
    
    // Thêm loading state
    bankSelect.innerHTML = '<option value="">-- Đang tải danh sách ngân hàng --</option>';
    
    fetch('{{ route("admin.bank-accounts.banks") }}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('API Response:', data);
        if (data.code === '00' && data.data && Array.isArray(data.data)) {
            bankSelect.innerHTML = '<option value="">-- Chọn ngân hàng --</option>';
            
            data.data.forEach(bank => {
                const option = document.createElement('option');
                option.value = bank.shortName;
                option.textContent = bank.name;
                option.setAttribute('data-short-name', bank.shortName);
                option.setAttribute('data-logo', bank.logo);
                
                if (currentBankName === bank.shortName) {
                    option.selected = true;
                }
                
                bankSelect.appendChild(option);
            });
        } else {
            console.error('Invalid API response:', data);
            bankSelect.innerHTML = '<option value="">-- Lỗi: Dữ liệu không hợp lệ --</option>';
        }
    })
    .catch(error => {
        console.error('Lỗi khi tải danh sách ngân hàng:', error);
        bankSelect.innerHTML = '<option value="">-- Lỗi khi tải danh sách ngân hàng --</option>';
        
        // Thử fallback với route public
        fetch('/test-banks')
            .then(response => response.json())
            .then(data => {
                if (data.code === '00' && data.data) {
                    bankSelect.innerHTML = '<option value="">-- Chọn ngân hàng (Fallback) --</option>';
                    data.data.forEach(bank => {
                        const option = document.createElement('option');
                        option.value = bank.shortName;
                        option.textContent = bank.name;
                        if (currentBankName === bank.shortName) {
                            option.selected = true;
                        }
                        bankSelect.appendChild(option);
                    });
                }
            })
            .catch(fallbackError => {
                console.error('Fallback cũng thất bại:', fallbackError);
            });
    });
});
</script>
@endsection
