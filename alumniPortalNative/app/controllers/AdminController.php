<?php
require_once __DIR__.'/../helpers/utils.php';
require_once __DIR__.'/../helpers/auth.php';
require_once __DIR__.'/../models/AlumniModel.php';
function admin_dashboard(){ require_role('admin'); view('admin/dashboard.php'); }
function admin_pending(){ require_role('admin'); $list=AlumniModel::getPending(); view('admin/pending.php',[ 'list'=>$list ]); }
function admin_approve(){ require_role('admin'); $id=(int)input('id'); AlumniModel::setStatus($id,'verified'); redirect('admin/pending'); }
function admin_reject(){ require_role('admin'); $id=(int)input('id'); AlumniModel::setStatus($id,'rejected'); redirect('admin/pending'); }
function admin_alumni_index(){ require_role('admin'); $list=AlumniModel::all(); view('admin/alumni_index.php',[ 'list'=>$list ]); }
function admin_alumni_edit(){
  require_role('admin');
  $id=(int)input('id');
  $al=AlumniModel::findById($id);
  if(!$al){ redirect('admin/alumni'); }
  view('admin/alumni_edit.php',[ 'p'=>$al ]);
}

function admin_alumni_update(){
  require_role('admin');
  $id = (int)input('id_alumni'); 
  if (!$id) $id = (int)input('id');

  // Validasi: Kalau ID masih 0 atau kosong, tendang balik
  if (!$id) {
      $_SESSION['flash'] = 'Error: ID Alumni tidak ditemukan.';
      redirect('admin/alumni'); 
      return;
  }

  $cfg = require __DIR__.'/../config/config.php';

  $data=[
    'nama_lengkap'=>trim(input('nama_lengkap')),
    'tempat_lahir'=>trim(input('tempat_lahir')),
    'tanggal_lahir'=>input('tanggal_lahir') ?: null,
    'angkatan'=>input('angkatan') ?: null,
    'jurusan'=>trim(input('jurusan')),
    'pekerjaan'=>trim(input('pekerjaan')),
    'pekerjaan_detail'=>trim(input('pekerjaan_detail')),
    'deskripsi'=>trim(input('deskripsi')),
    'nim'=>trim(input('nim')),
    'foto_path'=>null
  ];

  // 1) Jika ada hasil crop (base64) dari form
  if (!empty($_POST['foto_cropped'])) {
    $dataUri = $_POST['foto_cropped'];
    if (preg_match('/^data:image\/(\w+);base64,/', $dataUri, $m)) {
      $ext = strtolower($m[1]); // jpg/png/webp
      $imgData = base64_decode(substr($dataUri, strpos($dataUri, ',') + 1));
      if(!is_dir($cfg['upload_dir'])) mkdir($cfg['upload_dir'],0775,true);
      $filename = safe_filename($ext);
      $path = $cfg['upload_dir'].'/'.$filename;
      file_put_contents($path, $imgData);
      $data['foto_path'] = $cfg['upload_url'].'/'.$filename;
    }
  }

  // 2) Fallback: kalau nggak ada foto_cropped, cek upload file biasa
  if(empty($data['foto_path']) && isset($_FILES['foto']) && $_FILES['foto']['error']===UPLOAD_ERR_OK){
    $mime = mime_content_type($_FILES['foto']['tmp_name']);
    if(!in_array($mime,$cfg['allowed_mime'])){ $_SESSION['flash']='Tipe file tidak didukung'; redirect('admin/alumni/edit?id='.$id); }
    if($_FILES['foto']['size'] > $cfg['max_upload_bytes']){ $_SESSION['flash']='Ukuran foto terlalu besar'; redirect('admin/alumni/edit?id='.$id); }
    $ext = ext_by_mime($mime);
    if(!is_dir($cfg['upload_dir'])) mkdir($cfg['upload_dir'],0775,true);
    $filename = safe_filename($ext);
    $dest = $cfg['upload_dir'].'/'.$filename;
    move_uploaded_file($_FILES['foto']['tmp_name'],$dest);
    $data['foto_path'] = $cfg['upload_url'].'/'.$filename;
  }

  // Update data ke database
  AlumniModel::updateById($id,$data);
  
  $_SESSION['flash']='Data alumni berhasil diperbarui.';

  // --- LOGIKA REDIRECT BARU DISINI ---
  // Tangkap value dari input hidden name="redirect_source"
  $source = input('redirect_source'); 

  if ($source === 'pending') {
      redirect('admin/pending');
  } else {
      redirect('admin/alumni');
  }
}

function admin_alumni_delete(){
  require_role('admin');
  if($_SERVER['REQUEST_METHOD']!=='POST'){ redirect('admin/alumni'); }
  if(!csrf_check(input('csrf'))){ $_SESSION['flash']='Invalid CSRF token.'; redirect('admin/alumni'); }

  $id = (int)input('id');
  $st = DB::conn()->prepare('SELECT user_id FROM alumni_profiles WHERE id=?');
  $st->execute([$id]);
  $row = $st->fetch();

  // Admin tidak boleh hapus dirinya sendiri
  if($row && $row['user_id'] == current_user()['id']){
    $_SESSION['flash'] = 'Tidak bisa menghapus akun admin yang sedang login.';
    redirect('admin/alumni');
  }

  $ok = AlumniModel::deleteCascadeByProfileId($id);
  $_SESSION['flash'] = $ok ? 'Alumni berhasil dihapus.' : 'Data tidak ditemukan.';
  redirect('admin/alumni');
}

