<?php

use App\Http\Controllers\LoginControl;
use Illuminate\Support\Facades\Route;

// Route untuk halaman login
Route::get('/login', [LoginControl::class, 'showLoginForm'])->name('login');

// Route untuk proses login
Route::post('/login', [LoginControl::class, 'login']);

Route::get('/dashboard/admin', [LoginControl::class, 'adminDashboard'])->name('dashboard.admin')->middleware('auth', 'role:admin');
Route::get('/dashboard/dosen', [LoginControl::class, 'dosenDashboard'])->name('dashboard.dosen')->middleware('auth', 'role:dosen');
Route::get('/dashdekan', [LoginControl::class, 'dashDekan'])->name('dashdekan')->middleware('auth', 'role:dekan');
Route::get('/dashboard/mahasiswa', [LoginControl::class, 'mahasiswaDashboard'])->name('dashboard.mahasiswa')->middleware('auth', 'role:mahasiswa');

// Route untuk dashboard utama
Route::get('/dashboard', [LoginControl::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

// Route khusus untuk dekan
Route::get('/dashdekan', [LoginControl::class, 'dashDekan'])
    ->middleware(['auth', 'role:dekan'])
    ->name('dashdekan');

// Route untuk logout
Route::post('/logout', [LoginControl::class, 'logout'])->name('logout');

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});