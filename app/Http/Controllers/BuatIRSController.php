<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\IRS;
use App\Models\IRSDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuatIRSController extends Controller
{
    public function index()
    {
        // Mengambil jadwal yang sudah disetujui 
        $jadwal = Jadwal::with('matakuliah')
                    ->where('status', 'Setujui')
                    ->get();
        
        // Mengambil matakuliah yang sudah ada di irs
        $selectedMatkul = IRSDetail::join('irs', 'irs_details.irs_id', '=', 'irs.id')
                    ->where('irs_details.mahasiswa_id', 1)
                    ->where('irs.status', '!=', 'Dibatalkan')
                    ->pluck('matakuliah_id')
                    ->toArray();

        return view('buatirs', compact('jadwal', 'selectedMatkul'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Mengecek ada IRS untuk semester ini apa engga
            $existingIRS = IRS::where('mahasiswa_id', 1)
                            ->where('semester', $request->semester)
                            ->first();

            if ($existingIRS) {
                // Update IRS yang ada
                $irs = $existingIRS;
            } else {
                // Buat IRS baru
                $irs = IRS::create([
                    'mahasiswa_id' => 1,
                    'semester' => $request->semester,
                    'status' => 'Belum Disetujui'
                ]);
            }

            foreach($request->matakuliah as $mk) {
                // Untuk mengecek matakuliah sudah ada atau belom
                $existingDetail = IRSDetail::where('irs_id', $irs->id)
                                        ->where('matakuliah_id', $mk['id'])
                                        ->first();

                if (!$existingDetail) {
                    IRSDetail::create([
                        'irs_id' => $irs->id,
                        'mahasiswa_id' => 1,
                        'matakuliah_id' => $mk['id'],
                        'jadwal_id' => $mk['jadwal_id']
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'IRS berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan IRS: ' . $e->getMessage()
            ], 500);
        }
    }
}