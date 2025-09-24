@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm tài khoản game mới</h4>
                    <h6>Nhập thông tin tài khoản game</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.accounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Ảnh <span class="text-danger">*</span></label>
                                    <input type="file" name="thumb" class="form-control @error('thumb') is-invalid @enderror" accept="image/*">
                                    @error('thumb')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giá <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price') }}"
                                        class="form-control @error('price') is-invalid @enderror">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Liên kết</label>
                                    <input type="text" name="note" value="{{ old('note') }}" class="form-control @error('note') is-invalid @enderror" placeholder="Nhập liên kết..." onkeypress="handleEnterKey(event)">
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Hệ điều hành <span class="text-danger">*</span></label>
                                    <select name="planet" class="form-select @error('planet') is-invalid @enderror">
                                        <option value="earth" {{ old('planet') == 'earth' ? 'selected' : '' }}>Android</option>
                                        <option value="namek" {{ old('planet') == 'namek' ? 'selected' : '' }}>iOS</option>
                                    </select>
                                    @error('planet')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Ảnh mô tả</label>
                                    <input type="file" name="images[]" multiple class="form-control @error('images.*') is-invalid @enderror" accept="image/*">
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Tạo mới</button>
                                <a href="{{ route('admin.accounts.index') }}" class="btn btn-cancel">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function handleEnterKey(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.querySelector('form').submit();
            }
        }
    </script>
@endpush
