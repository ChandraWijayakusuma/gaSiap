<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\IRS;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {
        // Ambil IRS terbaru dari mahasiswa
        $latestIrs = IRS::where('mahasiswa_id', 1)  // Ganti dengan ID mahasiswa yang sesuai
                       ->latest()
                       ->first();

        $semester = $latestIrs ? $latestIrs->semester : 1;
        $statusRegistrasi = Mahasiswa::where('status', 'Aktif')->exists()
        ? 'Aktif'
        : 'Cuti';

        return view('dashboard.dashmahasiswa', [
            'semester' => $semester,
            'statusRegistrasi' => $statusRegistrasi
        ]);
    }
}