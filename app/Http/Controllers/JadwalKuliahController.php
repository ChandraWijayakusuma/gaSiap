<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Ruang;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $jadwalData = $request->input('jadwal');

        Log::info($jadwalData);
        // Validate the jadwal data
        $validator = Validator::make($jadwalData, [
            '*.hari' => 'required',
            '*.jam_mulai' => 'required',
            '*.jam_selesai' => 'required',
            '*.mata_kuliah_id' => 'required|exists:matakuliah,id',
            '*.ruang' => 'required',
        ]);

        Log::info('Sebelum validasi');
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        Log::info('Setelah validasi');
    
        DB::beginTransaction();
        Log::info('Memulai proses penyimpanan jadwal');
        try {
            Log::info('Sebelum delete jadwal');
            Jadwal::where('id', '>', 0)->delete();
            Log::info('Setelah delete jadwal');

            Log::info('Sebelum perulangan foreach');
            foreach ($jadwalData as $data) {
                Log::info('Dalam perulangan foreach, memproses data: ' . json_encode($data));
                Jadwal::create([
                    'hari' => $data['hari'],
                    'jam_mulai' => $data['jam_mulai'],
                    'jam_selesai' => $data['jam_selesai'],
                    'ruangan' => $data['ruang'],
                    'matakuliah_id' => $data['mata_kuliah_id'],
                    'status' => 'Belum Disetujui',
                ]);
            }
            Log::info('Setelah perulangan foreach');

            Log::info('Sebelum commit transaksi');
            DB::commit();
            Log::info('Setelah commit transaksi');
            Log::info('Jadwal berhasil disimpan');

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Terjadi kesalahan saat menyimpan jadwal: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan jadwal' . $e->getMessage()
            ], 500);
        }
    }


    // Menampilkan pengajuan jadwal untuk Dekan
public function viewPengajuan()
{
    // Ambil semua jadwal dengan relasi matakuliah
    $jadwal = Jadwal::with('matakuliah')->get();
    
    // Cek status persetujuan jadwal
    $statusJadwal = Jadwal::where('status', 'Belum Disetujui')->exists()
        ? 'Belum Disetujui'
        : 'Disetujui';

    return view('dekan.penyetujuan_jadwal', compact('jadwal', 'statusJadwal'));
}

    public function dashKapro()
    {
        $statusJadwal = Jadwal::where('status', 'Belum Disetujui')->exists()
            ? 'Belum Disetujui'
            : 'Disetujui';

        $irsTerverifikasi = 10; // Contoh jumlah data IRS Terverifikasi
        $irsBelumTerverifikasi = 15; // Contoh jumlah data IRS Belum Terverifikasi

        return view('dashboard.dashkapro', compact('statusJadwal', 'irsTerverifikasi', 'irsBelumTerverifikasi'));
    }

    // Approve semua jadwal
    public function approveAllJadwal()
    {
        try {
            Jadwal::where('status', 'Belum Disetujui')
                ->update(['status' => 'Setujui']);
    
            return redirect()->back()->with('success', 'Semua jadwal berhasil disetujui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui jadwal');
        }
    }
    
    // Reject semua jadwal
    public function rejectAllJadwal()
    {
        try {
            Jadwal::where('status', 'Setujui')
                ->update(['status' => 'Belum Disetujui']);
    
            return redirect()->back()->with('success', 'Semua jadwal ditolak');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak jadwal');
        }
    }

    // Lihat Jadwal
    public function lihatJadwal()
    {
        // Ambil semua jadwal dengan relasi matakuliah
        $jadwal = Jadwal::with('matakuliah')->get();
        
        // Cek status persetujuan jadwal
        $statusJadwal = Jadwal::where('status', 'Belum Disetujui')->exists()
            ? 'Belum Disetujui'
            : 'Disetujui';

        return view('lihatjadwal', compact('jadwal', 'statusJadwal'));
    }
}
