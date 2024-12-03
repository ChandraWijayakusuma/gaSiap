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
        try {
            $data = json_decode($request->input('jadwal'), true);
            
            if (!is_array($data) || empty($data)) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Invalid data format'
                ], 400);
            }

            DB::transaction(function () use ($data) {
                // Hapus semua data di tabel jadwal
                Jadwal::truncate(); // Gunakan truncate agar lebih efisien

                // Simpan data baru
                foreach ($data as $jadwal) {
                    Jadwal::create([
                        'day' => $jadwal['hari'],
                        'hour' => $jadwal['jam_mulai'], 
                        'hari' => $jadwal['hari'],
                        'jam_mulai' => $jadwal['jam_mulai'],
                        'jam_selesai' => $jadwal['jam_selesai'],
                        'matakuliah_id' => $jadwal['mata_kuliah'],
                        'room' => $jadwal['ruang'],
                        'ruangan' => $jadwal['ruang'],
                        'status' => 'Belum Setujui'  // Default status
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            Log::error('Jadwal submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
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
