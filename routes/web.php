<?php

use App\Http\Controllers\LoginControl;
use Illuminate\Support\Facades\Route;

// Route untuk halaman login
Route::get('/login', [LoginControl::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginControl::class, 'login'])->name('login.process');

// Route untuk dashboard berdasarkan role tanpa middleware
Route::get('/dashboard', [LoginControl::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/dekan', [LoginControl::class, 'dashDekan'])->name('dashboard.dekan');
Route::get('/dashboard/BA', [LoginControl::class, 'dashBA'])->name('dashboard.ba'); // Route untuk BA
Route::get('/dashboard/kapro', [LoginControl::class, 'dashKapro'])->name('dashboard.kapro');
Route::get('/dashboard/user', [LoginControl::class, 'dashUser'])->name('dashboard.user');
Route::get('/dashboard/dosen', [LoginControl::class, 'dashDosen'])->name('dashboard.dosen');
Route::get('/dashboard/mahasiswa', [LoginControl::class, 'dashMahasiswa'])->name('dashboard.mahasiswa');

// Route untuk logout
Route::post('/logout', [LoginControl::class, 'logout'])->name('logout');

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});
