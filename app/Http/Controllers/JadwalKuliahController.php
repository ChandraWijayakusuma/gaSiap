<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Ruang;
use App\Models\Jadwal; // Pastikan model Jadwal ada dan terhubung dengan database
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalKuliahController extends Controller
{
    // Menampilkan Jadwal Kuliah
    public function showJadwal()
    {
        // Ambil semua data jadwal dari database, bersama relasi Mata Kuliah dan Ruang
        $jadwal = Jadwal::with(['matakuliah', 'ruang'])->get();

        // Ambil data Mata Kuliah untuk list draggable
        $matakuliah = Matakuliah::all();

        // Ambil semua ruangan yang sesuai dengan prodi 'Informatika'
        $ruangan = Ruang::where('prodi', 'Informatika')->get();

        // Kirim data ke view
        return view('jadwalkuliah', compact('jadwal', 'matakuliah', 'ruangan'));
    }

    // Submit Jadwal ke database
    public function submitJadwal(Request $request)
    {
        try {
            $request->validate([
                'jadwal' => 'required|array',
                'jadwal.*.day' => 'required|string',
                'jadwal.*.hour' => 'required|string',
                'jadwal.*.matakuliah_id' => 'required|integer',
                'jadwal.*.room' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors());
        }

        // Proses penyimpanan
        foreach ($request->jadwal as $data) {
            Jadwal::create([
                'hari' => $data['day'],
                'jam' => $data['hour'],
                'matakuliah_id' => $data['matakuliah_id'],
                'ruangan' => $data['room'],
                'status' => 'Pending',
            ]);
        }

        return redirect()->route('dekan.jadwal.penyetujuan')->with('success', 'Jadwal berhasil diajukan.');
    }



    // Menampilkan pengajuan jadwal untuk Dekan
    public function viewPengajuan()
    {
        // Ambil semua jadwal dengan status 'Pending'
        $jadwal = Jadwal::with(['matakuliah', 'ruang'])
            ->where('status', 'Pending')
            ->get();

        return view('dekan.penyetujuan_jadwal', compact('jadwal'));
    }

    // Menyetujui jadwal oleh Dekan
    public function approveJadwal(Request $request, $id)
    {
        // Validasi data input (meskipun hanya status yang diubah, tetap lakukan validasi)
        $request->validate([
            'status' => 'required|in:Setujui,Belum Setujui',
        ]);

        // Temukan jadwal berdasarkan ID
        $jadwal = Jadwal::findOrFail($id);

        // Ubah status menjadi "Setujui"
        $jadwal->status = 'Setujui';
        $jadwal->save();

        return redirect()->back()->with('success', 'Jadwal berhasil disetujui.');
    }



    // Menolak jadwal oleh Dekan
    public function rejectJadwal(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'status' => 'required|in:Setujui,Belum Setujui',
        ]);

        // Temukan jadwal berdasarkan ID
        $jadwal = Jadwal::findOrFail($id);

        // Ubah status menjadi "Belum Setujui"
        $jadwal->status = 'Belum Setujui';
        $jadwal->save();

        return redirect()->back()->with('success', 'Jadwal belum disetujui.');
    }

}
