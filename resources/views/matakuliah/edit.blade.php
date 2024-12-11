@extends('layouts.app')

@section('content')
    <h1>Edit Matakuliah</h1>

    <form action="{{ route('matakuliah.update', $matakuliah) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="kode_matakuliah">Kode Matakuliah</label>
            <input type="text" name="kode_matakuliah" value="{{ $matakuliah->kode_matakuliah }}" required>
        </div>

        <div>
            <label for="nama_matakuliah">Nama Matakuliah</label>
            <input type="text" name="nama_matakuliah" value="{{ $matakuliah->nama_matakuliah }}" required>
        </div>

        <!-- Tambahkan input untuk field lainnya -->

        <button type="submit">Update</button>
    </form>
@endsection