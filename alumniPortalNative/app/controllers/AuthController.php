<?php
require_once __DIR__.'/../helpers/utils.php';
require_once __DIR__.'/../helpers/csrf.php';
require_once __DIR__.'/../helpers/auth.php';
require_once __DIR__.'/../models/UserModel.php';
require_once __DIR__.'/../models/AlumniModel.php';

// ===================================================
// LOGIN
// ===================================================
function show_login(){ view('auth/login.php'); }

function do_login(){
  if(!csrf_check(input('csrf'))){
    $_SESSION['flash'] = 'Sesi kadaluarsa. Coba lagi.';
    redirect('login');
    exit;
  }

  $email = trim((string)input('email',''));
  $pass  = (string)input('password','');

  if($email==='' || $pass===''){
    $_SESSION['flash'] = 'Email dan password wajib diisi.';
    redirect('login');
    exit;
  }

  $u = UserModel::findByEmail($email);
  if(!$u || !password_verify($pass,$u['password_hash'])){
    $_SESSION['flash'] = 'Email atau password salah.';
    redirect('login');
    exit;
  }

  login(['id'=>$u['id'],'email'=>$u['email'],'role'=>$u['role']]);

  // ADMIN → dashboard admin
  if($u['role']==='admin'){
    redirect('admin');
    exit;
  }

  // ALUMNI → cek kelengkapan profil
  $p = AlumniModel::findByUser($u['id']);
  if(!$p || !AlumniModel::isRowComplete($p)){
    $_SESSION['flash'] = 'Lengkapi profil agar data dapat ditampilkan di list alumni.';
    redirect('alumni/profile/edit');
    exit;
  }

  redirect('search');
  exit;
}

// ===================================================
// REGISTER
// ===================================================
function show_register(){ view('auth/register.php'); }

function do_register(){
  if(!csrf_check(input('csrf'))) die('Invalid CSRF');

  $email = trim(input('email')); 
  $pass  = input('password'); 
  $nama  = trim(input('nama_lengkap'));
  $nim   = trim(input('nim'));

  // === Validasi dasar ===
  if(!is_email_uns($email)) {
    $_SESSION['flash'] = 'Gunakan email @uns.ac.id';
    redirect('register');
    exit;
  }

  if(UserModel::findByEmail($email)){
    $_SESSION['flash'] = 'Email sudah terdaftar';
    redirect('register');
    exit;
  }

  // === Validasi password ===
  if (strlen($pass) < 8) {
    $_SESSION['flash'] = 'Password minimal 8 karakter.';
    redirect('register');
    exit;
  }

  if (!preg_match('/[0-9]/', $pass) || !preg_match('/[\W_]/', $pass)) {
    $_SESSION['flash'] = 'Password harus mengandung angka dan simbol.';
    redirect('register');
    exit;
  }

  // === Simpan user baru ===
  $hash = password_hash($pass, PASSWORD_BCRYPT);
  $uid  = UserModel::create($email,$hash,'alumni');

  // Insert profil awal
  AlumniModel::upsertProfile($uid, [
    'nama_lengkap'    => $nama,
    'tempat_lahir'    => null,
    'tanggal_lahir'   => null,
    'angkatan'        => null,
    'jurusan'         => null,
    'pekerjaan'       => null,
    'pekerjaan_detail'=> null,
    'deskripsi'       => null,
    'foto_path'       => null,
    'nim'             => $nim ?: null
  ]);

  // Login otomatis
  login([ 'id'=>$uid,'email'=>$email,'role'=>'alumni' ]);
  $_SESSION['flash'] = 'Lengkapi profil terlebih dahulu agar bisa tampil di daftar alumni.';
  redirect('alumni/profile/edit');
  exit;
}

// ===================================================
// LOGOUT
// ===================================================
function do_logout(){
  logout();
  redirect('login');
  exit;
}
