\# PHP Native Web Application



Aplikasi web berbasis \*\*PHP Native\*\* yang dijalankan menggunakan \*\*XAMPP\*\* sebagai web server dan database server.



🛠 Requirements

\- XAMPP (Apache \& MySQL)

\- Web Browser

\- Text Editor (VS Code atau sejenisnya)



📂 Cara Menjalankan Project



**1. Letakkan Project**

Salin folder project ke dalam direktori:

*C:\\xampp\\htdocs\\*



***2. Jalankan XAMPP***

*- Buka \*\*XAMPP Control Panel\*\**

*- Start \*\*Apache\*\**

*- Start \*\*MySQL\*\**



***3. Setup Database***

*1. Buka browser dan akses: http://localhost/phpmyadmin*

*2. Buat database baru dengan nama:alumni\_portal*

*3. Import file database:*

   *- Pilih database `alumni\_portal`*

   *- Klik tab \*\*Import\*\**

   *- Upload file `.sql`*

   *- Klik \*\*Go\*\**



***4. Konfigurasi Koneksi Database***

*Pastikan file koneksi database db.php berisi*



*```php*

*<?php*

*$host = "localhost";*

*$user = "root";*

*$pass = "";*

*$db   = "alumni\_portal";*



*$conn = mysqli\_connect($host, $user, $pass, $db);*



*if (!$conn) {*

    *die("Koneksi database gagal: " . mysqli\_connect\_error());*

*}*

*?>*





**5. Akses Aplikasi**



Buka browser dan akses:

http://localhost/akumni\_portal

