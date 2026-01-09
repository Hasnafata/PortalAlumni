<?php
function current_user() { return $_SESSION['user'] ?? null; }
function require_login() { if (!current_user()) redirect('login'); }
function require_role($role) {
    require_login();
    if (current_user()['role'] !== $role) redirect('login');
}
function login($user) { $_SESSION['user'] = $user; }
function logout() { $_SESSION = []; session_destroy(); }
function redirect($path) {
    $base = require __DIR__.'/../config/config.php';
    header('Location: '.$base['base_url'].'/'.$path);
    exit;
}