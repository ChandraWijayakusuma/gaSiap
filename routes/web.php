<?php

use App\Http\Controllers\DashboardDekanController;
use App\Http\Controllers\LoginControl;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\JadwalKuliahController; // Tambahkan ini untuk jadwalkuliah
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\BuatIRSController;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\PenyetujuanIRSController;

use Illuminate\Support\Facades\Route;

// Route untuk halaman login
Route::get('/login', [LoginControl::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginControl::class, 'login'])->name('login.process');

// Route untuk dashboard berdasarkan role
Route::get('/dashboard', [LoginControl::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/dekan', [LoginControl::class, 'dashDekan'])->name('dashboard.dekan');
Route::get('/dashboard/BA', [LoginControl::class, 'dashBA'])->name('dashboard.ba');
Route::get('/dashboard/kapro', [LoginControl::class, 'dashKapro'])->name('dashboard.kapro');
Route::get('/dashboard/user', [LoginControl::class, 'dashUser'])->name('dashboard.user');
Route::get('/dashboard/dosen', [LoginControl::class, 'dashDosen'])->name('dashboard.dosen');
Route::get('/dashboard/mahasiswa', [LoginControl::class, 'dashMahasiswa'])->name('dashboard.mahasiswa');

// Route untuk halaman makeruang dan pengelolaan ruangan
Route::get('/makeruang', [RuangController::class, 'create'])->name('makeruang');
Route::post('/makeruang', [RuangController::class, 'store'])->name('rooms.store'); // Menambah ruangan baru
Route::patch('/update-room/{id}', [RuangController::class, 'update'])->name('rooms.update'); // Mengedit ruangan
Route::delete('/delete-room/{id}', [RuangController::class, 'destroy'])->name('rooms.destroy'); // Menghapus ruangan
Route::patch('/clear-prodi/{id}', [RuangController::class, 'clearProdi'])->name('rooms.clearProdi'); // Mengosongkan prodi
Route::get('/pengajuan-ruang', [RuangController::class, 'showPengajuanRuang'])->name('rooms.pengajuan');
Route::patch('/setujui-ruang/{id}', [RuangController::class, 'setujuiRuang'])->name('rooms.setujui');
Route::patch('/setujui-semua-ruang', [RuangController::class, 'setujuiSemua'])->name('rooms.setujuiSemua');

// Route untuk jadwal kuliah
Route::get('/jadwalkuliah', [JadwalKuliahController::class, 'showJadwal'])->name('jadwalkuliah'); // Tampilkan jadwal kuliah
Route::post('/submit-jadwal', [JadwalKuliahController::class, 'submitJadwal'])->name('submit.jadwal'); // Ajukan jadwal
Route::get('/dekan/jadwal/penyetujuan', [JadwalKuliahController::class, 'viewPengajuan'])->name('dekan.jadwal.penyetujuan');
Route::get('/penyetujuan-jadwal', [JadwalKuliahController::class, 'viewPengajuan'])->name('penyetujuan.jadwal');
Route::post('/approve-all-jadwal', [JadwalKuliahController::class, 'approveAllJadwal'])->name('approve.all.jadwal');
Route::post('/reject-all-jadwal', [JadwalKuliahController::class, 'rejectAllJadwal'])->name('reject.all.jadwal');
Route::get('/dashboard/dekan', [DashboardDekanController::class, 'index'])->name('dashboard.dekan');
Route::get('/dekan/penyetujuan-jadwal', [JadwalKuliahController::class, 'penyetujuanJadwal'])->name('dekan.penyetujuan.jadwal');
Route::get('/dashboard/kapro', [JadwalKuliahController::class, 'dashKapro'])->name('dashboard.kapro');
Route::get('/lihat-jadwal', [JadwalKuliahController::class, 'lihatJadwal'])->name('lihat.jadwal');

// Route buat matakuliah
Route::get('/matakuliah/create', [MatakuliahController::class, 'create'])->name('matakuliah.create');
Route::post('/matakuliah', [MatakuliahController::class, 'store'])->name('matakuliah.store');
Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
Route::get('/matakuliah/{matakuliah}/edit', [MatakuliahController::class, 'edit'])->name('matakuliah.edit');
Route::delete('/matakuliah/{matakuliah}', [MatakuliahController::class, 'destroy'])->name('matakuliah.destroy');
Route::put('/matakuliah/{matakuliah}', [MatakuliahController::class, 'update'])->name('matakuliah.update');

// Route untuk Registrasi Akademik
Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi');
Route::post('/registrasi/update', [RegistrasiController::class, 'updateStatus'])->name('registrasi.update');
Route::get('/dashboard/mahasiswa', [DashboardMahasiswaController::class, 'index'])->name('dashboard.mahasiswa');

//Route untuk Membuat IRS
Route::get('/buat-irs', [BuatIRSController::class, 'index'])->name('buat.irs');
Route::post('/irs/store', [BuatIRSController::class, 'store'])->name('irs.store');
Route::get('/lihat-irs', [IRSController::class, 'show'])->name('lihat.irs');
Route::delete('/irs/delete-matkul/{id}', [IRSController::class, 'deleteMatkulIRS'])->name('irs.delete.matkul');

//Route untuk Penyetujuan IRS
Route::post('/irs/ajukan/{id}', [IRSController::class, 'ajukanIRS'])->name('irs.ajukan');
Route::get('/penyetujuan-irs', [PenyetujuanIRSController::class, 'index'])->name('penyetujuan.irs');
Route::post('/penyetujuan-irs/approve/{id}', [PenyetujuanIRSController::class, 'approve'])->name('penyetujuan.irs.approve');
Route::post('/penyetujuan-irs/reject/{id}', [PenyetujuanIRSController::class, 'reject'])->name('penyetujuan.irs.reject');
Route::get('/dashboard/dosen', [DashboardDosenController::class, 'index'])->name('dashboard.dosen');

//Route untuk mendownload IRS menjadi PDF
Route::get('/irs/download-pdf/{id}', [IRSController::class, 'downloadPDF'])->name('irs.download-pdf');

// Route untuk logout
Route::post('/logout', [LoginControl::class, 'logout'])->name('logout');

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});
