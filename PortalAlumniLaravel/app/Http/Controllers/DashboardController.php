<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $pending = User::where('role', 'alumni')->where('status', 'pending')->latest()->get();
            $history = User::where('role', 'alumni')->whereIn('status', ['verified', 'rejected'])->latest()->get();
            $query = User::where('role', 'alumni');
            if($request->has('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search.'%')
                      ->orWhere('nim', 'like', '%'.$request->search.'%');
                });
            }
            $alumni = $query->latest()->get();
            return view('admin.dashboard', compact('pending', 'history', 'alumni'));
        }
        return view('alumni.dashboard', compact('user'));
    }

    public function show($id) {
        if (Auth::user()->role !== 'admin') abort(403);
        $alumni = User::findOrFail($id);
        return view('admin.detail', compact('alumni'));
    }

    public function create() {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('admin.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required|unique:users,nim', 
            'jurusan' => 'required',
            'angkatan' => 'required|numeric',
            'password' => 'required|min:8|regex:/[0-9]/' 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
            'status' => 'verified',
            'pekerjaan' => 'Belum mengisi pekerjaan',
            'bio' => 'Belum ada deskripsi diri.'
        ]);

        return redirect()->route('dashboard')->with('success', 'Alumni berhasil ditambahkan!');
    }

    // FORM EDIT (ADMIN)
    public function edit($id) {
        if (Auth::user()->role !== 'admin') abort(403);
        $user = User::findOrFail($id); 
        return view('admin.edit', compact('user'));
    }

    // UPDATE DARI HALAMAN ADMIN
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->merge(['email' => trim($request->email), 'nim' => trim($request->nim)]);

        $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'nim' => ['nullable', Rule::unique('users')->ignore($user->id)], // Ubah required jadi nullable
        'jurusan' => 'required',
        'angkatan' => 'required|numeric',
    ]);

        $this->handlePhoto($request, $user);

        $user->fill($request->only(['name', 'email', 'nim', 'jurusan', 'angkatan', 'bio', 'pekerjaan']));
        if ($request->filled('password')) $user->password = Hash::make($request->password);
        if ($request->filled('nim')) {
        $user->nim = $request->nim;}
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Data berhasil diupdate Admin!');
    }

    // FORM EDIT (ALUMNI SENDIRI)
    public function editProfile() {
        $user = Auth::user();
        return view('alumni.edit', compact('user'));
    }

    // UPDATE DARI HALAMAN PROFIL ALUMNI
    public function updateProfile(Request $request) {
        $user = Auth::user(); 
        $request->merge(['email' => trim($request->email)]);

        // PERHATIKAN: NIM TIDAK ADA DI VALIDASI INI
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $this->handlePhoto($request, $user);

        $data = $request->only(['name', 'email', 'jurusan', 'angkatan', 'bio', 'pekerjaan']);
        if($request->filled('password')) {
            $request->validate(['password' => 'min:8|regex:/[0-9]/']);
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)->update($data);
        return redirect()->route('dashboard')->with('success', 'Profil Anda berhasil diupdate!');
    }

    // HELPER FOTO
    private function handlePhoto($request, $user) {
        if ($request->filled('foto_cropped')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $imgData = $request->foto_cropped;
            $imgData = substr($imgData, strpos($imgData, ',') + 1);
            $imgData = base64_decode($imgData);
            $fileName = 'profile_photos/' . time() . '_' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, $imgData);
            $user->foto = $fileName;
            $user->save();
        }
    }

    public function updateStatus($id, $status) {
        User::findOrFail($id)->update(['status' => $status]);
        return back()->with('success', 'Status diperbarui!');
    }

    public function delete($id) {
        $user = User::findOrFail($id);
        if ($user->foto) Storage::disk('public')->delete($user->foto);
        $user->delete();
        return back()->with('success', 'Data dihapus.');
    }
}