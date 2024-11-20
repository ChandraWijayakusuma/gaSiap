<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyetujuan Jadwal - Dekan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-purple-700 p-4 flex justify-between items-center">
        <a href="{{ route('dashboard.dekan') }}" class="text-white text-2xl font-bold">gaSIAP</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Logout</button>
        </form>
    </header>

    <div class="container mx-auto px-6 py-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Penyetujuan Jadwal</h2>
        <table class="table-auto w-full border-collapse border border-gray-200 bg-white shadow-lg">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 px-4 py-2">Mata Kuliah</th>
                    <th class="border border-gray-300 px-4 py-2">Hari</th>
                    <th class="border border-gray-300 px-4 py-2">Jam</th>
                    <th class="border border-gray-300 px-4 py-2">Ruangan</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $j)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $j->matakuliah->nama_matakuliah }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $j->hari }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $j->jam }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $j->ruang->nama_ruang }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $j->status }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($j->status === 'Pending')
                                <form method="POST" action="{{ route('approve.jadwal', $j->id) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('reject.jadwal', $j->id) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Tolak</button>
                                </form>
                            @else
                                <span class="text-gray-500">Tidak Ada Aksi</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
