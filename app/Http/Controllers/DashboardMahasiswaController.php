<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function index() {
        $statusRegistrasi = Mahasiswa::where('status', 'Aktif')->exists()
         ? 'Aktif' 
         : 'Cuti';

    
            return view('dashboard.dashmahasiswa', compact('statusRegistrasi'));
    }
}