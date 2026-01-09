<?php
require_once __DIR__.'/../config/db.php';
class UserModel {
    public static function findByEmail($email){
        $st=DB::conn()->prepare('SELECT * FROM users WHERE email=? LIMIT 1');
        $st->execute([$email]);
        return $st->fetch();
    }
    public static function findById($id){
        $st=DB::conn()->prepare('SELECT * FROM users WHERE id=?');
        $st->execute([$id]);
        return $st->fetch();
    }
    public static function create($email,$hash,$role='alumni'){
        $st=DB::conn()->prepare('INSERT INTO users(email,password_hash,role) VALUES(?,?,?)');
        $st->execute([$email,$hash,$role]);
        return DB::conn()->lastInsertId();
    }
}