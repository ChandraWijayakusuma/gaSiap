<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\IRS;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuatIRSController extends Controller
{
    public function __construct()
    {
        $user = Auth::user();  // Memastikan pengguna terautentikasi
    }

    // Menampilkan form IRS
    public function createIRS()
    {
        $matakuliah = MataKuliah::all();
        $semesterMahasiswa = Auth::user()->semester; // Asumsi ada atribut semester di user
        return view('buatirs', compact('matakuliah', 'semesterMahasiswa'));
    }

    // Menyimpan IRS
    public function submitIRS(Request $request)
    {
        $user = Auth::user();

        // Validasi data IRS
        $request->validate([
            'mata_kuliah' => 'required|array',
            'mata_kuliah.*' => 'exists:mata_kuliahs,id',
        ]);
    
        $totalSKS = 0;
        $selectedCourses = MataKuliah::whereIn('id', $request->mata_kuliah)->get();
    
        // Cek batas SKS
        foreach ($selectedCourses as $course) {
            $totalSKS += $course->sks;
        }
    
        if ($totalSKS > 24) {
            return redirect()->back()->with('error', 'Jumlah SKS melebihi batas maksimum (24 SKS)');
        }
    
        // Cek prioritas semester
        foreach ($selectedCourses as $course) {
            if ($course->semester > $user->semester) {
                return redirect()->back()->with('error', 'Mata kuliah ini tidak dapat diambil karena bukan prioritas semester Anda');
            }
        }
    
        // Cek bentrok jadwal
        foreach ($selectedCourses as $course) {
            if ($this->checkScheduleConflict($user, $course)) {
                return redirect()->back()->with('error', 'Ada bentrok jadwal dengan mata kuliah lain');
            }
        }
    
        // Menyimpan IRS
        foreach ($selectedCourses as $course) {
            IRS::create([
                'mahasiswa_id' => $user->id,
                'mata_kuliah_id' => $course->id,
                'semester' => $user->semester,
            ]);
        }
    
        // Setelah berhasil menyimpan IRS, kirimkan pesan sukses
        return redirect()->route('buat.irs')->with('success', 'IRS berhasil disubmit!');
    }

    public function showBuatIRS()
{
    // Ambil data semester mahasiswa
    $semesterMahasiswa = $user = Auth::user()->mahasiswa->semester; // Misalnya, mahasiswa punya atribut semester

    // Ambil data mata kuliah yang sesuai
    $matakuliah = Matakuliah::all();

    // Kirim data ke view
    return view('buatirs', compact('semesterMahasiswa', 'matakuliah'));
}

    
    // Mengecek bentrok jadwal
    private function checkScheduleConflict($user, $course)
    {
        // Cari jadwal mahasiswa
        $jadwalMahasiswa = Jadwal::where('mata_kuliah_id', $course->id)->get();

        // Cek apakah ada jadwal yang bentrok
        foreach ($jadwalMahasiswa as $jadwal) {
            $existingSchedule = Jadwal::where('user_id', $user->id)
                                      ->where('hari', $jadwal->hari)
                                      ->where(function ($query) use ($jadwal) {
                                          $query->whereBetween('jam_mulai', [$jadwal->jam_mulai, $jadwal->jam_selesai])
                                                ->orWhereBetween('jam_selesai', [$jadwal->jam_mulai, $jadwal->jam_selesai]);
                                      })
                                      ->exists();

            if ($existingSchedule) {
                return true;
            }
        }

        return false;
    }
}
