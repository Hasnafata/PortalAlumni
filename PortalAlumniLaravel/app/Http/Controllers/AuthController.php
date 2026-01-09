<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // --- LOGIN ---
    
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login'); // Pastikan file ada di resources/views/auth/login.blade.php
    }

    // Proses masuk
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- REGISTER ---

    // Menampilkan halaman daftar
    public function showRegister()
    {
        return view('auth.register'); // Pastikan file ada di resources/views/auth/register.blade.php
    }

    // Proses pendaftaran
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required|unique:users,nim',
            'jurusan' => 'required',
            'angkatan' => 'required|numeric',
            'pekerjaan' => 'required|string|max:255', // Tambahkan ini
            'bio' => 'required',
            'password' => 'required|min:8|confirmed',
            'foto_cropped' => 'required' // Pastikan foto wajib diisi
        ]);

        // Logika simpan foto (Base64) tetap sama...
        $imgData = $request->foto_cropped;
        $imgData = substr($imgData, strpos($imgData, ',') + 1);
        $imgData = base64_decode($imgData);
        $fileName = 'profile_photos/' . time() . '_' . uniqid() . '.png';
        Storage::disk('public')->put($fileName, $imgData);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
            'pekerjaan' => $request->pekerjaan, // Tambahkan ini
            'bio' => $request->bio,
            'password' => Hash::make($request->password),
            'foto' => $fileName,
            'role' => 'alumni',
            'status' => 'pending' // Biar diverifikasi admin dulu
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Tunggu verifikasi admin.');
    }

    // --- LOGOUT ---

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}