<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginControl extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Fungsi login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Data login
        $credentials = $request->only('email', 'password');

        // Cek autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Debugging untuk memastikan role terbaca dengan benar
            if (!$user->role) {
                return redirect()->back()->withErrors(['error' => 'Role tidak ditemukan untuk pengguna ini']);
            }

            // Redirect berdasarkan role
            return $this->redirectToRoleDashboard($user->role);
        }

        // Kembali ke halaman login jika autentikasi gagal
        return redirect()->back()->withErrors(['error' => 'Email atau password salah']);
    }

    // Fungsi untuk mengarahkan pengguna ke dashboard sesuai role
    private function redirectToRoleDashboard($role)
    {
        switch ($role) {
            case 'dekan':
                return redirect()->route('dashboard.dekan');
            case 'BA':
                return redirect()->route('dashboard.ba');
            case 'kapro':
                return redirect()->route('dashboard.kapro');
            case 'user':
                return redirect()->route('dashboard.user');
            case 'dosen':
                return redirect()->route('dashboard.dosen');
            case 'mahasiswa':
                return redirect()->route('dashboard.mahasiswa');
            default:
                return redirect()->route('login')->withErrors(['error' => 'Role tidak dikenali']);
        }
    }

    // Fungsi dashboard umum yang mengarahkan berdasarkan role
    public function dashboard()
    {
        $user = Auth::user();

        if ($user) {
            return $this->redirectToRoleDashboard($user->role);
        }

        return redirect()->route('login')->withErrors(['error' => 'Anda harus login terlebih dahulu']);
    }

    // Fungsi logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Fungsi dashboard khusus untuk setiap role
    public function dashDekan()
    {
        return view('dashboard.dashdekan');
    }

    public function dashBA()
    {
        return view('dashboard.dashba');
    }

    public function dashKapro()
    {
        return view('dashboard.dashkapro');
    }

    public function dashUser()
    {
        return view('dashboard.dashuser');
    }

    public function dashDosen()
    {
        return view('dashboard.dashdosen');
    }

    public function dashMahasiswa()
    {
        return view('dashboard.dashmahasiswa');
    }
}
