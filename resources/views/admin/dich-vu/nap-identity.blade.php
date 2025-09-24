@extends('layouts.admin.app')

@section('title', 'Nạp Identity')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Nạp Identity</h4>
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
                    <input type="hidden" name="scope" value="nap-identity">
                    <div class="form-group">
                        <label for="thumbnail">Chọn ảnh đại diện mới</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật ảnh</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nội dung trang Nạp Identity</h5>
                
                <form id="identityForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="identity_text">Nội dung</label>
                        <div id="editor" style="height: 300px;"></div>
                        <textarea name="identity_text" id="identity_text" style="display: none;">{{ $identityText }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu nội dung</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quill Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Update hidden textarea when content changes
    quill.on('text-change', function() {
        document.getElementById('identity_text').value = quill.root.innerHTML;
    });

    // Form submission for identity text
    document.getElementById('identityForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("admin.dich-vu.update-identity-text") }}', {
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
            } else {
                messageDiv.className = 'alert alert-danger';
                messageDiv.textContent = data.message;
                messageDiv.style.display = 'block';
            }
            
            // Ẩn thông báo sau 5 giây
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        })
        .catch(error => {
            console.error('Error:', error);
            const messageDiv = document.getElementById('message');
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = 'Có lỗi xảy ra khi cập nhật nội dung';
            messageDiv.style.display = 'block';
            
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        });
    });

    // Form submission for service thumbnail
    const thumbForm = document.getElementById('serviceThumbForm');
    if (thumbForm) {
        thumbForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submitted');

            const formData = new FormData(this);
            console.log('FormData created:', formData);

            fetch('{{ route("admin.dich-vu.update-service-thumbnail") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                const messageDiv = document.getElementById('message');
                if (data.success) {
                    messageDiv.className = 'alert alert-success';
                    messageDiv.textContent = data.message;
                    messageDiv.style.display = 'block';

                    // Cập nhật ảnh hiện tại nếu có
                    const currentThumbnail = document.querySelector('.current-thumbnail img');
                    if (currentThumbnail && data.thumbnail_url) {
                        currentThumbnail.src = data.thumbnail_url + '?v=' + Date.now();
                    }
                } else {
                    messageDiv.className = 'alert alert-danger';
                    messageDiv.textContent = data.message;
                    messageDiv.style.display = 'block';
                }

                // Ẩn thông báo sau 5 giây
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                }, 5000);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật ảnh: ' + error.message);
            });
        });
    } else {
        console.error('Form not found');
    }
});
</script>
@endsection