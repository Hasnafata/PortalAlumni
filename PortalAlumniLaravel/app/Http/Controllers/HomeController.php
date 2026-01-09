<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Halaman Depan (Landing Page)
    public function index() {
        // Hitung statistik untuk dipamerkan di depan
        $count = User::where('role', 'alumni')->where('status', 'verified')->count();
        return view('welcome', compact('count'));
    }

    // Halaman List Alumni (Publik)
    public function alumni(Request $request) {
        // Hanya tampilkan yang VERIFIED
        $query = User::where('role', 'alumni')->where('status', 'verified');

        // Fitur Cari
        if ($request->has('search')) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', '%'.$keyword.'%')
                  ->orWhere('nim', 'like', '%'.$keyword.'%')
                  ->orWhere('jurusan', 'like', '%'.$keyword.'%')
                  ->orWhere('angkatan', 'like', '%'.$keyword.'%');
            });
        }

        $alumni = $query->latest()->get();
        return view('public-alumni', compact('alumni'));
    }
}