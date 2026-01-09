<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

// === HALAMAN PUBLIK ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/alumni', [HomeController::class, 'alumni'])->name('alumni.list');

// === AUTH (GUEST ONLY) ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === HALAMAN KHUSUS MEMBER (ADMIN/ALUMNI) ===
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // === EDIT PROFIL SENDIRI ===
    // Pastikan method editProfile & updateProfile ada di DashboardController
    Route::get('/profile/edit', [DashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // === ADMIN ONLY ROUTES ===
    Route::get('/admin/status/{id}/{status}', [DashboardController::class, 'updateStatus'])->name('admin.status');
    Route::get('/admin/create', [DashboardController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [DashboardController::class, 'store'])->name('admin.store');
    Route::get('/admin/edit/{id}', [DashboardController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/update/{id}', [DashboardController::class, 'update'])->name('admin.update');
    Route::get('/admin/delete/{id}', [DashboardController::class, 'delete'])->name('admin.delete');
});