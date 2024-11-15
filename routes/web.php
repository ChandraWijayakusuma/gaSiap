<?php

use App\Http\Controllers\LoginControl;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\JadwalKuliahController; // Tambahkan ini untuk jadwalkuliah
use Illuminate\Support\Facades\Route;

// Route untuk halaman login
Route::get('/login', [LoginControl::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginControl::class, 'login'])->name('login.process');

// Route untuk dashboard berdasarkan role tanpa middleware
Route::get('/dashboard', [LoginControl::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/dekan', [LoginControl::class, 'dashDekan'])->name('dashboard.dekan');
Route::get('/dashboard/BA', [LoginControl::class, 'dashBA'])->name('dashboard.ba');
Route::get('/dashboard/kapro', [LoginControl::class, 'dashKapro'])->name('dashboard.kapro');
Route::get('/dashboard/user', [LoginControl::class, 'dashUser'])->name('dashboard.user');
Route::get('/dashboard/dosen', [LoginControl::class, 'dashDosen'])->name('dashboard.dosen');
Route::get('/dashboard/mahasiswa', [LoginControl::class, 'dashMahasiswa'])->name('dashboard.mahasiswa');

// Route untuk halaman jadwal kuliah
Route::get('/jadwalkuliah', [JadwalKuliahController::class, 'index'])->name('jadwalkuliah'); // Tambahkan route untuk jadwal kuliah

// Route untuk halaman makeruang dan pengelolaan ruangan
Route::get('/makeruang', [RuangController::class, 'create'])->name('makeruang');
Route::post('/makeruang', [RuangController::class, 'store'])->name('rooms.store'); // Menambah ruangan baru
Route::patch('/update-room/{id}', [RuangController::class, 'update'])->name('rooms.update'); // Mengedit ruangan
Route::delete('/delete-room/{id}', [RuangController::class, 'destroy'])->name('rooms.destroy'); // Menghapus ruangan
Route::patch('/clear-prodi/{id}', [RuangController::class, 'clearProdi'])->name('rooms.clearProdi'); // Mengosongkan prodi
Route::get('/pengajuan-ruang', [RuangController::class, 'showPengajuanRuang'])->name('rooms.pengajuan');
Route::patch('/setujui-ruang/{id}', [RuangController::class, 'setujuiRuang'])->name('rooms.setujui');
Route::patch('/setujui-semua-ruang', [RuangController::class, 'setujuiSemua'])->name('rooms.setujuiSemua');
Route::get('/dashboard/dekan', [RuangController::class, 'dashDekan'])->name('dashboard.dekan');
Route::get('/dashboard/BA', [RuangController::class, 'getStatusRuang'])->name('dashboard.ba');


// Route untuk logout
Route::post('/logout', [LoginControl::class, 'logout'])->name('logout');

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});
