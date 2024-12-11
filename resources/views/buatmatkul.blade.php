<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Matakuliah - gaSiap</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .header {
            background-color: #4a148c;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body class="bg-gray-100">
    <header class="header">
        <a href="{{ route('dashboard') }}" class="text-white text-2xl font-bold">gaSIAP</a>
    </header>

    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-4">Buat Matakuliah Baru</h2>
        
        <form method="POST" action="{{ route('matakuliah.store') }}" class="bg-white p-6 rounded-lg shadow-md mb-8">
            @csrf
            <div class="mb-4">
                <label for="kode_matakuliah" class="block text-gray-700 font-semibold mb-2">Kode Matakuliah</label>
                <input type="text" name="kode_matakuliah" id="kode_matakuliah" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="nama_matakuliah" class="block text-gray-700 font-semibold mb-2">Nama Matakuliah</label>
                <input type="text" name="nama_matakuliah" id="nama_matakuliah" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="prodi" class="block text-gray-700 font-semibold mb-2">Program Studi</label>
                <input type="text" name="prodi" id="prodi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="sks" class="block text-gray-700 font-semibold mb-2">SKS</label>
                <input type="number" name="sks" id="sks" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="semester" class="block text-gray-700 font-semibold mb-2">Semester</label>
                <input type="number" name="semester" id="semester" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" rows="4"></textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Simpan</button>
            </div>
        </form>

        <h2 class="text-2xl font-semibold mb-4">Daftar Matakuliah</h2>

        <table class="w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-100 font-semibold text-left">Kode</th>
                    <th class="py-2 px-4 bg-gray-100 font-semibold text-left">Nama</th>
                    <th class="py-2 px-4 bg-gray-100 font-semibold text-left">Prodi</th>
                    <th class="py-2 px-4 bg-gray-100 font-semibold text-left">SKS</th>
                    <th class="py-2 px-4 bg-gray-100 font-semibold text-left">Semester</th>
                    <th class="py-2 px-4 bg-gray-100 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matakuliah as $mk)
                <tr>
                    <td class="py-2 px-4">{{ $mk->kode_matakuliah }}</td>
                    <td class="py-2 px-4">{{ $mk->nama_matakuliah }}</td>
                    <td class="py-2 px-4">{{ $mk->prodi }}</td>
                    <td class="py-2 px-4">{{ $mk->sks }}</td>
                    <td class="py-2 px-4">{{ $mk->semester }}</td>
                    <td class="py-2 px-4 text-center">
                        
                        <form action="{{ route('matakuliah.destroy', $mk->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus matakuliah ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>