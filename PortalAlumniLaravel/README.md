**Sistem Informasi Portal Alumni UNS**

Aplikasi manajemen database alumni Universitas Sebelas Maret (UNS) yang dirancang untuk mendata profil profesional lulusan secara akurat dan interaktif. Aplikasi ini dibangun menggunakan framework Laravel dengan fitur unggulan pengolahan citra (image cropping) untuk standarisasi foto profil.



**Fitur Utama**

1\. Manajemen Profil Berbasis Peran (Role-Based)

Akses Alumni:

* Memperbarui data profesional (Pekerjaan, Instansi, Bio).
* Mengubah data akademik (Jurusan, Angkatan).
* Keamanan Data: NIM bersifat Read-Only (hanya baca) untuk mencegah manipulasi identitas oleh pengguna.
* Akses Administrator:
* Kontrol penuh terhadap seluruh database pengguna.
* Wewenang untuk memperbaiki data master, termasuk pengeditan NIM jika terjadi kesalahan input saat registrasi.



**2. Standarisasi Foto Profil (Image Cropping)**

Integrasi library Cropper.js pada sisi klien (client-side).

* Memastikan setiap foto yang diunggah memiliki rasio aspek 1:1 (Square).
* Proses pemotongan gambar dilakukan sebelum data dikirim ke server untuk menghemat bandwidth dan penyimpanan.



**3. Antarmuka (UI/UX) Profesional**

* Implementasi desain menggunakan Bootstrap 5.
* Penggunaan palet warna resmi UNS (Biru UNS: #0076bd).
* Tipografi modern menggunakan font Inter untuk keterbacaan yang maksimal.
* Identitas visual dengan favicon dan logo resmi Universitas Sebelas Maret.



-----------------------



**Spesifikasi Teknologi**

Framework: Laravel 10/11



Bahasa Pemrograman: PHP >= 8.1



Database: MySQL / MariaDB



Frontend: Blade Templating, CSS (Bootstrap 5), JavaScript (Vanilla \& Cropper.js)



Icons: Bootstrap Icons



-----------------------------

**Panduan Instalasi \& Deployment**

Lakukan langkah-langkah berikut untuk menjalankan project di lingkungan lokal:



**1. Persiapan Awal**

Pastikan folder project sudah diekstrak, kemudian buka terminal/command prompt di direktori tersebut.



**2. Instalasi Dependensi**

Instal seluruh library PHP yang diperlukan melalui Composer:



Bash

*"composer install"*



**3. Konfigurasi Environment \& Database**

Pastikan file .env sudah tersedia di root folder.



Sesuaikan parameter database berikut dengan konfigurasi server lokal Anda:



Cuplikan kode



DB\_CONNECTION=mysql

DB\_HOST=127.0.0.1

DB\_PORT=3306

DB\_DATABASE=nama\_database\_anda

DB\_USERNAME=root

DB\_PASSWORD=

Pastikan APP\_URL sesuai dengan alamat akses (default: http://127.0.0.1:8000).



jalankan perintah:

bash

*"php artisan migrate"*



(Opsional) Jalankan Seeder: Jika Anda ingin mengisi database dengan data awal (seperti akun Admin default atau data alumni dummy), jalankan:

Bash:

*php artisan db:seed"*



**4. Sinkronisasi Media (Penting)**

Aplikasi menggunakan symbolic link untuk mengakses file yang diunggah. Jika foto profil tidak muncul (pecah), jalankan perintah:



Bash

*"php artisan storage:link"*



Catatan: Jika folder public/storage sudah ada namun gambar tetap pecah/tidak terdeteksi, hapus folder tersebut secara manual lalu jalankan kembali perintah di atas.



**5. Menjalankan Aplikasi**

Nyalakan server pengembangan Laravel:



Bash

*"php artisan serve"*

Akses aplikasi melalui browser di alamat http://127.0.0.1:8000.



----------------------------



Struktur Folder Penting

* app/Http/Controllers: Logika pemrosesan data (Update profil, Cropping logic).
* resources/views/layouts/app.blade.php: Layout utama, konfigurasi Favicon, dan Header/Footer.
* resources/views/admin/: Halaman manajemen khusus administrator.
* resources/views/profile/: Halaman manajemen profil mandiri alumni.
* public/storage/: Lokasi penyimpanan fisik foto profil yang diunggah.
* database/migrations: Berisi skema tabel database (User, Alumni, dll).
* database/seeders: Berisi data awal untuk testing, termasuk akun super-admin.
