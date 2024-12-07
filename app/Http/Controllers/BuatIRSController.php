<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuatIRSController extends Controller
{
    /**
     * Menampilkan form pembuatan IRS
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = Auth::user();
        $semesterMahasiswa = $mahasiswa->semester;  // Ambil semester mahasiswa

        // Ambil mata kuliah berdasarkan prioritas semester mahasiswa
        $matakuliah = Matakuliah::orderByRaw("
            CASE
                WHEN semester = ? THEN 1  -- Prioritas untuk mahasiswa semester yang sama
                WHEN semester > ? THEN 2  -- Prioritas untuk mahasiswa semester yang lebih tinggi
                WHEN semester < ? THEN 3  -- Prioritas untuk mahasiswa semester yang lebih rendah
            END", [$semesterMahasiswa, $semesterMahasiswa, $semesterMahasiswa])
            ->get();

        // Ambil semua ruangan yang tersedia
        $ruangan = Ruang::all();

        // Tampilkan halaman form untuk membuat IRS
        return view('buatirs', compact('matakuliah', 'ruangan'));
    }

    /**
     * Menyimpan IRS yang dipilih oleh mahasiswa
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitIRS(Request $request)
    {
        // Ambil data yang dikirimkan dari form
        $mataKuliahIds = $request->input('mata_kuliah'); // Ini bisa berupa array
        $jamKuliah = $request->input('jam'); 
        $ruangan = $request->input('ruangan'); 

        $totalSKS = 0;
        $mahasiswa = Auth::user(); // Ambil data mahasiswa yang sedang login
        $semester = $mahasiswa->semester; // Semester mahasiswa yang sedang login

        // Ambil mata kuliah berdasarkan ID dan hitung total SKS
        foreach ($mataKuliahIds as $mataKuliahId) {
            $mataKuliah = Matakuliah::find($mataKuliahId);
            $totalSKS += $mataKuliah->sks;
        }

        // Periksa apakah total SKS melebihi batas maksimum
        if ($totalSKS > 24) {
            return redirect()->back()->with('error', 'Jumlah SKS melebihi kapasitas!');
        }

        // Simpan IRS ke database atau lakukan logika lain sesuai kebutuhan
        // Misalnya dengan model IRS atau mahasiswa-irs

        // Contoh redirect setelah proses penyimpanan
        return redirect()->route('lihatirs')->with('success', 'IRS berhasil disimpan!');
    }
}
