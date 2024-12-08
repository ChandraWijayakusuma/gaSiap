<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use Illuminate\Http\Request;

class DashboardDosenController extends Controller
{
public function index()
{
    $approvedCount = IRS::where('status', 'Disetujui', 'Ditolak')->count();
    $totalCount = IRS::whereIn('status', ['Menunggu Persetujuan'])->count();

    return view('dashboard.dashdosen', [
        'approvedCount' => $approvedCount,
        'totalCount' => $totalCount
    ]);
}
}