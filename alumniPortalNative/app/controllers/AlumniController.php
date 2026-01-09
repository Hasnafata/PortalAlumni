<?php
require_once __DIR__.'/../helpers/utils.php';
require_once __DIR__.'/../helpers/auth.php';
require_once __DIR__.'/../models/AlumniModel.php';


function alumni_profile(){
  require_login(); 
  $p=AlumniModel::findByUser(current_user()['id']); 
  if(!$p || !AlumniModel::isRowComplete($p)){
    $_SESSION['flash']='Profil belum lengkap. Lengkapi profil agar data dapat ditampilkan di list alumni.';
  }
  view('alumni/profile.php',[ 'p'=>$p ]);
}

function alumni_profile_edit(){ require_login(); $p=AlumniModel::findByUser(current_user()['id']); view('alumni/profile_edit.php',[ 'p'=>$p ]); }
function alumni_profile_update(){
  require_login();
  $cfg = require __DIR__.'/../config/config.php';

  // payload profil
  $payload = [
    'nama_lengkap'=>trim(input('nama_lengkap')),
    'tempat_lahir'=>trim(input('tempat_lahir')),
    'tanggal_lahir'=>input('tanggal_lahir') ?: null,
    'angkatan'=>input('angkatan') ?: null,
    'jurusan'=>trim(input('jurusan')),
    'pekerjaan'=>trim(input('pekerjaan')),
    'pekerjaan_detail'=>trim(input('pekerjaan_detail')),
    'deskripsi'=>trim(input('deskripsi')),
    'foto_path'=>null
  ];

  // 1) Hasil crop (base64) kalau ada
  if (!empty($_POST['foto_cropped'])) {
    $dataUri = $_POST['foto_cropped'];
    if (preg_match('/^data:image\/(\w+);base64,/', $dataUri, $m)) {
      $ext = strtolower($m[1]); // jpg/png/webp
      $imgData = base64_decode(substr($dataUri, strpos($dataUri, ',') + 1));
      if(!is_dir($cfg['upload_dir'])) mkdir($cfg['upload_dir'],0775,true);
      $filename = safe_filename($ext);
      $path = $cfg['upload_dir'].'/'.$filename;
      file_put_contents($path, $imgData);
      $payload['foto_path'] = $cfg['upload_url'].'/'.$filename;
    }
  }

  // 2) Fallback: upload file biasa jika tidak ada foto_cropped
  if(empty($payload['foto_path']) && isset($_FILES['foto']) && $_FILES['foto']['error']===UPLOAD_ERR_OK){
    $mime = mime_content_type($_FILES['foto']['tmp_name']);
    if(!in_array($mime,$cfg['allowed_mime'])){ $_SESSION['flash']='Tipe file tidak didukung'; redirect('alumni/profile/edit'); }
    if($_FILES['foto']['size'] > $cfg['max_upload_bytes']){ $_SESSION['flash']='Ukuran foto terlalu besar'; redirect('alumni/profile/edit'); }
    $ext = ext_by_mime($mime);
    if(!is_dir($cfg['upload_dir'])) mkdir($cfg['upload_dir'],0775,true);
    $filename = safe_filename($ext);
    $dest = $cfg['upload_dir'].'/'.$filename;
    move_uploaded_file($_FILES['foto']['tmp_name'],$dest);
    $payload['foto_path'] = $cfg['upload_url'].'/'.$filename;
  }

  // Simpan
  AlumniModel::upsertProfile(current_user()['id'],$payload);
  $_SESSION['flash']='Profil diperbarui.';
  redirect('alumni/profile');
}
