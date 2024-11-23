<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Ruang;
use Illuminate\Http\Request;

class DashboardDekanController extends Controller
{
    public function index()
    {
        // Cek status jadwal
        $statusJadwal = Jadwal::where('status', 'Belum Setujui')->exists()
            ? 'Belum Verifikasi'
            : 'Sudah Verifikasi';

        // Cek status ruang
        $statusRuang = Ruang::where('status_persetujuan', 'Belum Disetujui')->exists()
            ? 'Belum Verifikasi'
            : 'Sudah Verifikasi';

        return view('dashboard.dashdekan', compact('statusJadwal', 'statusRuang'));
    }
}