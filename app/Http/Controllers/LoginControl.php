<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginControl extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login'); // Pastikan 'login' sesuai dengan nama file Blade Anda di resources/views
    }

    // Fungsi login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',      // Atau 'username' jika tidak pakai email
            'password' => 'required|min:6',
        ]);

        // Data login
        $credentials = $request->only('email', 'password');

        // Cek autentikasi
        if (Auth::attempt($credentials)) {
            // Ambil data user yang sedang login
            $user = Auth::user();
            
            // Redirect ke halaman dashboard dengan mengirim role
            return redirect()->route('dashboard')->with('role', $user->role);
        }

        // Kembali ke halaman login jika gagal
        return redirect()->back()->withErrors(['error' => 'Email atau password salah']);
    }

    // Tampilan dashboard setelah login
    public function dashboard()
    {
        // Ambil role dari user yang sedang login
        $role = Auth::user()->role;
        
        // Kirim role ke view
        return view('dashboard', compact('role'));
    }
}
