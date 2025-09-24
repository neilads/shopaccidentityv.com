<?php
require __DIR__.'/../vendor/autoload.php'; // Thêm ../ để lên thư mục gốc
$app = require_once __DIR__.'/../bootstrap/app.php'; // Thêm ../ để lên thư mục gốc
$app->make('Illuminate\Contracts\Console\Kernel')->call('key:generate', ['--quiet' => true]); // Tạo ra 1 key mới
$app->make('Illuminate\Contracts\Console\Kernel')->call('storage:link'); // để upoload ảnh được
$app->make('Illuminate\Contracts\Console\Kernel')->call('app:clear'); // xóa cache
echo "Đã chạy thành công!";
?>