<?php
return [
    'app_name' => 'Alumni Portal',
    'base_url' => 'http://localhost/alumniPortal/public',
    'upload_dir' => __DIR__ . '/../../public/uploads',
    'upload_url' => 'uploads',
    'allowed_mime' => ['image/jpeg','image/png','image/webp'],
    'max_upload_bytes' => 2 * 1024 * 1024, // 2MB
];