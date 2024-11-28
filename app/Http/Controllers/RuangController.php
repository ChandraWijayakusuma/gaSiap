<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    // Menampilkan halaman makeruang dengan data ruangan
    public function create()
    {
        $rooms = Ruang::all();
        return view('makeruang', compact('rooms'));
    }

    // Fungsi untuk menambahkan ruangan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kuota_ruang' => 'required|integer|min:1',
        ]);

        Ruang::create([
            'nama_ruang' => $request->nama_ruang,
            'kuota_ruang' => $request->kuota_ruang,
            'prodi' => null,
            'status_persetujuan' => 'Belum Disetujui', // Default status
        ]);

        return redirect()->back()->with('success', 'Room added successfully.');
    }


    // Fungsi untuk mengupdate ruangan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kuota_ruang' => 'required|integer|min:1',
            'prodi' => 'nullable|string|max:255', // Prodi boleh kosong
        ]);

        $room = Ruang::findOrFail($id);

        // Reset status_persetujuan jika terjadi perubahan
        $room->update([
            'nama_ruang' => $request->nama_ruang,
            'kuota_ruang' => $request->kuota_ruang,
            'prodi' => $request->prodi,
            'status_persetujuan' => 'Belum Disetujui', // Set status menjadi "Belum Disetujui"
        ]);

        return redirect()->back()->with('success', 'Room updated successfully.');
    }


    // Fungsi untuk menghapus ruangan
    public function destroy($id)
    {
        $room = Ruang::findOrFail($id);
        $room->delete();

        return redirect()->back()->with('success', 'Room deleted successfully.');
    }

    // Menampilkan halaman pengajuan ruang untuk persetujuan dekan
    public function showPengajuanRuang()
    {
        $rooms = Ruang::all();
        return view('pengajuanruang', compact('rooms'));
    }

    // Fungsi untuk mengosongkan kolom prodi pada ruangan
    public function clearProdi($id)
    {
        $room = Ruang::findOrFail($id);
        $room->update([
            'prodi' => null,
            'status_persetujuan' => 'Belum Disetujui', // Set ulang status menjadi "Belum Disetujui"
        ]);

        return redirect()->back()->with('success', 'Prodi cleared successfully.');
    }


    // Menyetujui semua ruangan yang belum disetujui
    public function setujuiSemua()
    {
        Ruang::where('status_persetujuan', 'Belum Disetujui')->update(['status_persetujuan' => 'Disetujui']);
        return redirect()->back()->with('success', 'Semua ruangan telah disetujui.');
    }

    // Menyetujui status pengajuan pada satu ruangan
    public function setujuiRuang($id)
    {
        $room = Ruang::findOrFail($id);
        $room->update(['status_persetujuan' => 'Disetujui']);

        return redirect()->back()->with('success', 'Ruang telah disetujui.');
    }

    // Mendapatkan status ruang untuk tampilan dashboard BA
    public function getStatusRuang()
    {
        // Hitung total kelas
        $totalKelas = Ruang::count();

        // Hitung kelas yang terisi (di mana kolom `prodi` tidak kosong)
        $kelasTerisi = Ruang::whereNotNull('prodi')->count();

        // Hitung kelas yang tidak terisi (di mana kolom `prodi` kosong)
        $kelasTidakTerisi = Ruang::whereNull('prodi')->count();

        // Cek status pengajuan keseluruhan
        $statusPengajuan = Ruang::where('status_persetujuan', 'Belum Disetujui')->exists()
            ? 'Belum Disetujui'
            : 'Disetujui';

        // Kembalikan data ke view dashboard BA
        return  compact('totalKelas', 'kelasTerisi', 'kelasTidakTerisi', 'statusPengajuan');
    }

    // Mendapatkan status ruang untuk tampilan dashboard Dekan
    public function dashDekan()
    {
        // Cek apakah semua ruang sudah disetujui atau belum
        $statusPengajuanRuang = Ruang::where('status_persetujuan', 'Belum Disetujui')->exists()
            ? 'Belum Verifikasi'
            : 'Sudah Verifikasi';

        return view('dashboard.dashdekan', compact('statusPengajuanRuang'));
    }
}
