<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa; // Pastikan Anda menggunakan model yang sesuai

class RegistrasiController extends Controller
{
    public function index()
{
    // Ambil data status akademik dari database atau set default
    $statusAkademik = 'Belum Terpilih'; // Default status
    return view('registrasi', compact('statusAkademik'));
}

public function updateStatus(Request $request)
{
    // Validasi input
    $request->validate([
        'status' => 'required|in:Aktif,Cuti',
    ]);

    // Temukan mahasiswa berdasarkan nama
    $mahasiswa = Mahasiswa::where('nama', 'Andi')->first();

    if ($mahasiswa) {
        // Update status akademik
        $mahasiswa->status = $request->input('status');
        $mahasiswa->save();

        // Redirect kembali dengan pesan
        return redirect()->route('registrasi')->with('statusAkademik', $mahasiswa->status);
    }

    // Jika mahasiswa tidak ditemukan
    return redirect()->route('registrasi')->with('error', 'Mahasiswa tidak ditemukan.');
}
}