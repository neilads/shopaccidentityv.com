@extends('layouts.admin.app')

@section('title', 'Nạp Echoes')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Nạp Echoes</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ảnh Đại Diện Dịch Vụ</h5>

                <!-- Thông báo -->
                <div id="message" class="alert" style="display: none;"></div>

                <!-- Hiển thị ảnh hiện tại -->
                @if($currentService->thumbnail)
                    <div class="form-group">
                        <label>Ảnh hiện tại:</label>
                        <div class="current-thumbnail">
                            <img src="{{ $currentService->thumbnail }}" alt="Current thumbnail" style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>
                @endif

                <form id="serviceThumbForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="scope" value="nap-echoes">
                    <div class="form-group">
                        <label for="thumbnail">Chọn ảnh đại diện mới</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật ảnh</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const thumbForm = document.getElementById('serviceThumbForm');
    if (thumbForm) {
        thumbForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('{{ route("admin.dich-vu.update-service-thumbnail") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('message');
                if (data.success) {
                    messageDiv.className = 'alert alert-success';
                    messageDiv.textContent = data.message;
                    messageDiv.style.display = 'block';

                    const currentThumbnail = document.querySelector('.current-thumbnail img');
                    if (currentThumbnail && data.thumbnail_url) {
                        currentThumbnail.src = data.thumbnail_url + '?v=' + Date.now();
                    }
                } else {
                    messageDiv.className = 'alert alert-danger';
                    messageDiv.textContent = data.message;
                    messageDiv.style.display = 'block';
                }
                setTimeout(() => { messageDiv.style.display = 'none'; }, 5000);
            })
            .catch(error => {
                alert('Có lỗi xảy ra khi cập nhật ảnh: ' + error.message);
            });
        });
    }
});
</script>
@endsection