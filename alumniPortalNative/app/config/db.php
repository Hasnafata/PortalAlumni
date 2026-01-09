<?php
class DB {
    private static $pdo = null;

    public static function conn() {
        if (!self::$pdo) {

            // Data Source Name
            $dsn = 'mysql:host=127.0.0.1;dbname=alumni_portal;charset=utf8mb4';

            try {
                self::$pdo = new PDO($dsn, 'root', '', [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_PERSISTENT => false
                ]);
            } catch (PDOException $e) {
                die("Koneksi database gagal: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
