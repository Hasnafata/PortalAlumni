<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@uns.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'verified',
            'nim' => 'ADMIN001'
        ]);

        // Buat 1 Alumni Contoh
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'alumni',
            'status' => 'verified',
            'nim' => 'M0512001',
            'jurusan' => 'Informatika',
            'angkatan' => 2018,
            'pekerjaan' => 'Software Engineer'
        ]);
    }
}