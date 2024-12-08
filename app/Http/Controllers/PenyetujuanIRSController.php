<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use Illuminate\Http\Request;

class PenyetujuanIRSController extends Controller
{
    public function index()
    {
        $irsSubmissions = IRS::with(['mahasiswa', 'details.matakuliah'])
            ->where('status', 'Menunggu Persetujuan')
            ->get();
    
        return view('penyetujuanirs', compact('irsSubmissions'));
    }

    public function approve($id)
    {
        try {
            $irs = IRS::findOrFail($id);
            $irs->update([
                'status' => 'Disetujui',
                'tanggal_persetujuan' => now()
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'IRS berhasil disetujui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui IRS'
            ], 500);
        }
    }
    
    public function reject($id)
    {
        try {
            $irs = IRS::findOrFail($id);
            $irs->update([
                'status' => 'Ditolak',
                'tanggal_persetujuan' => now()
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'IRS berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak IRS'
            ], 500);
        }
    }

    public function detail($id)
    {
        $irs = IRS::with(['mahasiswa', 'details.matakuliah', 'details.jadwal'])
            ->findOrFail($id);

        return view('detailirs', compact('irs'));
    }
}
