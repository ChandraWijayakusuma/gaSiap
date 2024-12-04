<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Ruang;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class JadwalKuliahController extends Controller
{
    // Menampilkan Jadwal Kuliah
    public function showJadwal()
    {
        // Ambil semua data jadwal dari database, bersama relasi Mata Kuliah
        $jadwal = Jadwal::with(['matakuliah'])->get();

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
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Validasi data
            $request->validate([
                'mata_kuliah_id' => 'required',
                'dosen_id' => 'required',
                'ruangan_id' => 'required',
                'hari' => 'required',
                'jam' => 'required',
            ]);

            // Proses penyimpanan data jadwal
            $jadwal = new Jadwal();
            $jadwal->mata_kuliah_id = $request->mata_kuliah_id;
            $jadwal->dosen_id = $request->dosen_id;
            $jadwal->ruangan_id = $request->ruangan_id;
            $jadwal->hari = $request->hari;
            $jadwal->jam = $request->jam;
            $jadwal->save(); // Menyimpan jadwal

            // Jika semuanya berjalan lancar, komit transaksi
            DB::commit();
            
            // Redirect dengan pesan sukses
            return redirect()->route('jadwalkuliah')->with('success', 'Jadwal berhasil diajukan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Kembalikan ke halaman sebelumnya dengan error
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengajukan jadwal.']);
        }
    }

    // Menampilkan pengajuan jadwal untuk Dekan
    public function viewPengajuan()
    {
        $jadwal = Jadwal::with('matakuliah')->get();

        return view('dekan.penyetujuan_jadwal', compact('jadwal'));
    }

    public function dashKapro()
    {
        $statusJadwal = Jadwal::where('status', 'Belum Setujui')->exists()
            ? 'Belum Disetujui'
            : 'Disetujui';

        $irsTerverifikasi = 10; // Contoh jumlah data IRS Terverifikasi
        $irsBelumTerverifikasi = 15; // Contoh jumlah data IRS Belum Terverifikasi

        return view('dashboard.dashkapro', compact('statusJadwal', 'irsTerverifikasi', 'irsBelumTerverifikasi'));
    }

    // Approve semua jadwal
    public function approveAllJadwal()
    {
        Jadwal::where('status', 'Belum Setujui')
            ->update(['status' => 'Setujui']);

        return redirect()->back()->with('success', 'Semua jadwal berhasil disetujui');
    }

    // Reject semua jadwal
    public function rejectAllJadwal()
    {
        Jadwal::where('status', 'Setujui')
            ->update(['status' => 'Belum Setujui']);

        return redirect()->back()->with('success', 'Semua jadwal ditolak');
    }

    // Lihat Jadwal
    public function lihatJadwal()
    {
        $jadwal = Jadwal::with('matakuliah')->get();
        $statusJadwal = Jadwal::where('status', 'Belum Setujui')->exists()
            ? 'Belum Disetujui'
            : 'Disetujui';

        return view('lihatjadwal', compact('jadwal', 'statusJadwal'));
    }
}
