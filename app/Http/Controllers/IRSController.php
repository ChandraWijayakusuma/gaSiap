<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\IRSDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class IRSController extends Controller
{
    public function show()
    {
        $irs = IRS::where('mahasiswa_id', 1)->latest()->first();
        $irsDetails = IRSDetail::with(['matakuliah', 'jadwal'])
                     ->where('mahasiswa_id', 1)
                     ->where('irs_id', $irs ? $irs->id : 0)
                     ->get();
    
        return view('lihatirs', compact('irs', 'irsDetails'));
    }

    public function ajukanIRS($id)
    {
        DB::beginTransaction();
        try {
            $irs = IRS::findOrFail($id);
            
            // Update status IRS
            $irs->update([
                'status' => 'Menunggu Persetujuan'
            ]);
    
            DB::commit();
            return back()->with('success', 'IRS berhasil diajukan ke dosen wali');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengajukan IRS: ' . $e->getMessage());
        }
    }

    public function deleteMatkulIRS($id)
    {
        DB::beginTransaction();
        try {
            $irsDetail = IRSDetail::findOrFail($id);
            
            // Cek status IRS
            if ($irsDetail->irs->status !== 'Belum Disetujui') {
                return response()->json([
                    'success' => false,
                    'message' => 'IRS sudah diajukan/disetujui, tidak bisa dihapus'
                ]);
            }

            // Hapus detail IRS
            $irsDetail->delete();

            // Cek sisa matkul
            $remainingMatkul = IRSDetail::where('irs_id', $irsDetail->irs_id)->count();
            if ($remainingMatkul === 0) {
                IRS::find($irsDetail->irs_id)->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mata kuliah berhasil dihapus dari IRS'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus mata kuliah: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadPDF($id)
{
    $irs = IRS::findOrFail($id);
    $irsDetails = IRSDetail::with(['matakuliah', 'jadwal'])
                 ->where('irs_id', $id)
                 ->get();
    
    if ($irs->status !== 'Disetujui') {
        return redirect()->back()->with('error', 'IRS belum disetujui. Tidak dapat mengunduh PDF.');
    }

    $mahasiswa = $irs->mahasiswa;
    $totalSKS = $irsDetails->sum('matakuliah.sks');

    $pdf = PDF::loadView('pdf.irs', compact('irs', 'irsDetails', 'mahasiswa', 'totalSKS'));
    
    return $pdf->download('IRS_Semester_' . $irs->semester . '.pdf');
}
}