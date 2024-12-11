<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = Matakuliah::all();
        return view('matakuliah.index', compact('matakuliah'));
    }

    public function create()
    {
        $matakuliah = Matakuliah::all();
        return view('buatmatkul', compact('matakuliah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|unique:matakuliah',
            'nama_matakuliah' => 'required',
            'prodi' => 'required',
            'sks' => 'required|integer',
            'semester' => 'required|integer',
            'deskripsi' => 'nullable',
        ]);

        Matakuliah::create($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Matakuliah berhasil ditambahkan.');
    }

    public function show(Matakuliah $matakuliah)
    {
        return view('matakuliah.show', compact('matakuliah'));
    }

    public function edit(Matakuliah $matakuliah)
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $request->validate([
            'kode_matakuliah' => 'required|unique:matakuliah,kode_matakuliah,'.$matakuliah->id,
            'nama_matakuliah' => 'required',
            'prodi' => 'required',
            'sks' => 'required|integer',
            'semester' => 'required|integer',
            'deskripsi' => 'nullable',
        ]);

        $matakuliah->update($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Matakuliah berhasil diperbarui.');
    }

    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Matakuliah berhasil dihapus.');
    }
}