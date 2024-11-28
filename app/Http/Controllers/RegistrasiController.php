<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function index()
    {
        // Data status akademik (bisa diambil dari database jika diperlukan)
        $statusAkademik = 'Belum Terpilih'; // Default status
        return view('registrasi', compact('statusAkademik'));
    }

    public function updateStatus(Request $request)
    {
        // Perbarui status akademik berdasarkan pilihan user
        $status = $request->input('status');

        // Proses logika simpan ke database jika diperlukan
        // Misalnya: Status diubah menjadi "Aktif" atau "Cuti"

        return redirect()->route('registrasi')->with('statusAkademik', $status);
    }
}
