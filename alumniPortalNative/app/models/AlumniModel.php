<?php
require_once __DIR__.'/../config/db.php';

class AlumniModel {

  // === 1. List publik (untuk halaman utama) ===
  public static function getPublicList($q='',$page=1,$per=12){
    $off = ($page-1)*$per;
    $q2 = "%$q%";
    $sql = "SELECT a.id,a.nama_lengkap,a.foto_path,a.angkatan,a.jurusan
            FROM alumni_profiles a
            JOIN users u ON u.id = a.user_id
            WHERE a.status_verifikasi='verified'
              AND u.role='alumni'
              AND a.nama_lengkap <> ''
              AND a.angkatan IS NOT NULL
              AND a.jurusan IS NOT NULL
              AND (
                a.nama_lengkap LIKE ? OR CAST(a.angkatan AS CHAR) LIKE ? OR a.jurusan LIKE ?
              )
            ORDER BY a.nama_lengkap LIMIT $per OFFSET $off";
    $st = DB::conn()->prepare($sql);
    $st->execute([$q2,$q2,$q2]);
    return $st->fetchAll();
  }

  public static function countPublic($q=''){
    $q2 = "%$q%";
    $st = DB::conn()->prepare("SELECT COUNT(*) c
        FROM alumni_profiles a
        JOIN users u ON u.id=a.user_id
        WHERE a.status_verifikasi='verified'
          AND u.role='alumni'
          AND a.nama_lengkap <> ''
          AND a.angkatan IS NOT NULL
          AND a.jurusan IS NOT NULL
          AND (a.nama_lengkap LIKE ? OR CAST(a.angkatan AS CHAR) LIKE ? OR a.jurusan LIKE ?)");
    $st->execute([$q2,$q2,$q2]);
    return (int)$st->fetch()['c'];
  }

  // === 2. Ambil profil milik user login ===
  public static function findByUser($user_id){
    $st = DB::conn()->prepare('SELECT * FROM alumni_profiles WHERE user_id=? LIMIT 1');
    $st->execute([$user_id]);
    return $st->fetch();
  }

  // === 3. Cek apakah NIM sudah digunakan ===
  public static function nimExists($nim){
    $st = DB::conn()->prepare('SELECT COUNT(*) AS c FROM alumni_profiles WHERE nim = ?');
    $st->execute([$nim]);
    return (int)$st->fetch()['c'] > 0;
  }

  // === 4. Insert/update profil alumni ===
  public static function upsertProfile($user_id,$data){
    $exists = self::findByUser($user_id);

    // Jika belum punya profil → INSERT baru
    if (!$exists) {
      // Validasi: NIM wajib unik
      if (!empty($data['nim']) && self::nimExists($data['nim'])) {
        $_SESSION['flash'] = 'NIM sudah terdaftar. Gunakan NIM lain.';
        redirect('register');
      }

      $sql = 'INSERT INTO alumni_profiles
                (user_id, nama_lengkap, nim, tempat_lahir, tanggal_lahir, angkatan,
                 jurusan, pekerjaan, pekerjaan_detail, deskripsi, foto_path, status_verifikasi)
              VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
      DB::conn()->prepare($sql)->execute([
        $user_id,
        $data['nama_lengkap'],
        $data['nim'],
        $data['tempat_lahir'],
        $data['tanggal_lahir'],
        $data['angkatan'],
        $data['jurusan'],
        $data['pekerjaan'],
        $data['pekerjaan_detail'],
        $data['deskripsi'],
        $data['foto_path'] ?? null,
        'pending'
      ]);
      return DB::conn()->lastInsertId();
    }

    // Jika sudah punya profil → UPDATE tanpa menyentuh NIM
    $sql = 'UPDATE alumni_profiles SET
              nama_lengkap = ?,
              tempat_lahir = ?,
              tanggal_lahir = ?,
              angkatan = ?,
              jurusan = ?,
              pekerjaan = ?,
              pekerjaan_detail = ?,
              deskripsi = ?,
              foto_path = COALESCE(?, foto_path),
              updated_at = NOW()
            WHERE user_id = ?';
    DB::conn()->prepare($sql)->execute([
      $data['nama_lengkap'],
      $data['tempat_lahir'],
      $data['tanggal_lahir'],
      $data['angkatan'],
      $data['jurusan'],
      $data['pekerjaan'],
      $data['pekerjaan_detail'],
      $data['deskripsi'],
      $data['foto_path'],
      $user_id
    ]);
    return $exists['id'];
  }

  // === 5. Pending list (untuk admin approve/reject) ===
  public static function getPending($page=1,$per=20){
    $off = ($page-1)*$per;
    $st = DB::conn()->query(
      "SELECT a.*, u.email
       FROM alumni_profiles a
       JOIN users u ON u.id = a.user_id
       WHERE a.status_verifikasi = 'pending'
       ORDER BY a.created_at DESC
       LIMIT $per OFFSET $off"
    );
    return $st->fetchAll();
  }

  public static function setStatus($id,$status){
    $st = DB::conn()->prepare('UPDATE alumni_profiles SET status_verifikasi=? WHERE id=?');
    $st->execute([$status,$id]);
  }

  // === 6. Detail publik ===
  public static function findPublicById($id){
    $st = DB::conn()->prepare(
      "SELECT a.id, a.nama_lengkap, a.foto_path, a.angkatan, a.jurusan, a.deskripsi,
              a.pekerjaan, u.email
       FROM alumni_profiles a
       JOIN users u ON u.id = a.user_id
       WHERE a.id = ? AND a.status_verifikasi = 'verified'"
    );
    $st->execute([$id]);
    return $st->fetch();
  }

  // === 7. Detail lengkap (admin edit) ===
  public static function findById($id){
    $st = DB::conn()->prepare(
      "SELECT a.*, u.email
       FROM alumni_profiles a
       JOIN users u ON u.id = a.user_id
       WHERE a.id = ?"
    );
    $st->execute([$id]);
    return $st->fetch();
  }

  // === 8. Update oleh admin (boleh ubah NIM) ===
  public static function updateById($id,$data){
    // Cek jika NIM bentrok (kecuali profil yang sama)
    if (!empty($data['nim'])) {
      $st = DB::conn()->prepare('SELECT id FROM alumni_profiles WHERE nim=? AND id<>?');
      $st->execute([$data['nim'],$id]);
      if ($st->fetch()) {
        $_SESSION['flash'] = 'NIM sudah digunakan oleh alumni lain.';
        redirect('admin/alumni/edit?id='.$id);
      }
    }

    $sql = "UPDATE alumni_profiles SET
              nama_lengkap = ?,
              nim = ?,
              tempat_lahir = ?,
              tanggal_lahir = ?,
              angkatan = ?,
              jurusan = ?,
              pekerjaan = ?,
              pekerjaan_detail = ?,
              deskripsi = ?,
              foto_path = COALESCE(?, foto_path),
              updated_at = NOW()
            WHERE id = ?";
    DB::conn()->prepare($sql)->execute([
      $data['nama_lengkap'],
      $data['nim'],
      $data['tempat_lahir'],
      $data['tanggal_lahir'],
      $data['angkatan'],
      $data['jurusan'],
      $data['pekerjaan'],
      $data['pekerjaan_detail'],
      $data['deskripsi'],
      $data['foto_path'],
      $id
    ]);
  }

  // === 9. List semua alumni (admin) ===
  public static function all($page=1,$per=20){
    $off = ($page-1)*$per;
    $st = DB::conn()->query(
      "SELECT a.*, u.email
       FROM alumni_profiles a
       JOIN users u ON u.id = a.user_id
       ORDER BY a.created_at DESC
       LIMIT $per OFFSET $off"
    );
    return $st->fetchAll();
  }

  // === 10. Hapus alumni + user ===
  public static function deleteCascadeByProfileId($id){
    $st = DB::conn()->prepare('SELECT user_id FROM alumni_profiles WHERE id=?');
    $st->execute([$id]);
    $row = $st->fetch();
    if(!$row){ return false; }
    DB::conn()->prepare('DELETE FROM users WHERE id=?')->execute([$row['user_id']]);
    return true;
  }

  // === 11. Validasi kelengkapan data (agar tampil publik) ===
  public static function isRowComplete(array $row): bool {
    return !empty($row['nama_lengkap']) 
        && !empty($row['angkatan']) 
        && !empty($row['jurusan'])
        && !empty($row['pekerjaan'])
        && !empty($row['pekerjaan_detail'])
        && !empty($row['deskripsi'])
        && !empty($row['foto_path']);
}
}
