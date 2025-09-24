@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa tài khoản game</h4>
                    <h6>Cập nhật thông tin tài khoản game</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if ($account->status == 'sold' && $account->buyer_id)
                            <h4 class="text-danger">Tài khoản này đã được bán</h4>
                        @endif
                        <div class="row">
                            
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="number" name="price" value="{{ old('price', $account->price) }}" class="form-control @error('price') is-invalid @enderror">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Hệ điều hành</label>
                                    <select name="planet" class="form-select @error('planet') is-invalid @enderror">
                                        <option value="earth" {{ old('planet', $account->planet) == 'earth' ? 'selected' : '' }}>Android</option>
                                        <option value="namek" {{ old('planet', $account->planet) == 'namek' ? 'selected' : '' }}>iOS</option>
                                    </select>
                                    @error('planet')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Ảnh đại diện</label>
                                    <div class="image-upload">
                                        <input type="file" name="thumb"
                                            class="form-control @error('thumb') is-invalid @enderror" accept="image/*"
                                            onchange="previewImage(this, 'preview-thumb')">
                                        @error('thumb')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="Upload Image"
                                                style="max-width: 200px; max-height: 200px;">
                                            <h4>Kéo thả hoặc chọn ảnh để tải lên</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Ảnh chi tiết</label>
                                    <div class="image-upload">
                                        <input type="file" name="images[]" multiple
                                            class="form-control @error('images') is-invalid @enderror" accept="image/*"
                                            onchange="previewMultipleImages(this, 'preview-images')">
                                        @error('images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="Upload Images"
                                                style="max-width: 200px; max-height: 200px;">
                                            <h4>Kéo thả hoặc chọn nhiều ảnh để tải lên</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="thumb-wrapper" style="position:relative;display:inline-block;">
                                    @if($account->thumb)
                                        <img id="preview-thumb" src="{{ asset($account->thumb) }}" alt="preview"
                                            class="mx-auto d-block mb-3 preview-thumb" style="display:block;max-width:200px;max-height:200px;">
                                        <button type="button" class="btn btn-sm btn-danger delete-thumb-btn" title="Xóa ảnh đại diện"
                                            style="position:absolute;top:6px;right:6px;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;padding:0;line-height:1;">
                                            ×
                                        </button>
                                    @else
                                        <div class="text-muted">Chưa có ảnh đại diện</div>
                                    @endif
                                </div>
                                <input type="hidden" name="thumb_delete" id="thumb_delete" value="0">
                                <div id="preview-images" class="d-flex flex-wrap justify-content-center gap-3 mb-3">
                                    @if ($account->images)
                                        @foreach (json_decode($account->images) as $image)
                                            <div class="image-item" style="position:relative;display:inline-block;">
                                                <img src="{{ asset($image) }}" alt="preview" style="max-width: 200px; max-height: 200px;display:block;">
                                                <button type="button" class="btn btn-sm btn-danger delete-image-btn" data-url="{{ $image }}" title="Xóa ảnh"
                                                    style="position:absolute;top:6px;right:6px;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;padding:0;line-height:1;">
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-muted">Chưa có ảnh chi tiết</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Liên kết</label>
                                    <input type="text" name="note" value="{{ old('note', $account->note) }}" class="form-control @error('note') is-invalid @enderror" placeholder="Nhập liên kết..." onkeypress="handleEnterKey(event)">
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.accounts.index') }}" class="btn btn-cancel">Hủy bỏ</a>
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
        // Delete thumb with X button
        document.addEventListener('DOMContentLoaded', function() {
            const deleteThumbBtn = document.querySelector('.delete-thumb-btn');
            if (deleteThumbBtn) {
                deleteThumbBtn.addEventListener('click', function() {
                    const preview = document.getElementById('preview-thumb');
                    if (preview) preview.style.opacity = '0.3';
                    const hidden = document.getElementById('thumb_delete');
                    if (hidden) hidden.value = '1';
                });
            }

            // Delete gallery images with X button
            document.querySelectorAll('.delete-image-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    if (!url) return;
                    const container = this.closest('.image-item');
                    if (container) container.style.opacity = '0.3';
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'images_delete[]';
                    input.value = url;
                    document.querySelector('form').appendChild(input);
                });
            });
        });
        function handleEnterKey(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.querySelector('form').submit();
            }
        }
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, previewId) {
            var preview = document.getElementById(previewId);
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px';
                        img.style.maxHeight = '200px';
                        img.style.margin = '5px';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endpush
