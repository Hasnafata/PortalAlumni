<?php
function view($file, $data = []) {
extract($data);
    include __DIR__.'/../views/partials/head.php';
    include __DIR__.'/../views/partials/navbar.php';
    include __DIR__.'/../views/'.$file;
    include __DIR__.'/../views/partials/foot.php';
}
function input($key,$default=null){ return $_POST[$key] ?? $_GET[$key] ?? $default; }
function is_email_uns($email){ return (bool)preg_match('/@uns\.ac\.id$/i',$email); }
function safe_filename($ext='jpg'){ return bin2hex(random_bytes(16)).'.'.$ext; }
function ext_by_mime($mime){ return ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$mime] ?? 'jpg'; }