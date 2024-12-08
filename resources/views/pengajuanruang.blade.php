<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Ruang - gaSIAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<style>
        .header {
            background-color: #4a148c;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .breadcrumb {
            padding: 1rem 1.5rem;
            color: #6c757d;
        }

</style>
</head>
<body class="bg-gray-100">

<header class="header">
    <a href="{{ route('dashboard') }}" class="text-white text-2xl font-bold">gaSIAP</a>
</header>

<div class="breadcrumb">
    Home / Pengajuan Ruang
</div>

<div class="container mx-auto px-6 py-4">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Pengajuan Ruang</h2>

    <!-- Status Persetujuan -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold">Status Persetujuan:</h3>
            <p class="mt-1">
                @if ($rooms->every(fn($room) => $room->status_persetujuan === 'Disetujui'))
                    <span class="text-green-500 font-semibold">Semua ruangan sudah disetujui</span>
                @else
                    <span class="text-red-500 font-semibold">Belum Disetujui</span>
                @endif
            </p>
        </div>

        <!-- Tombol Setujui Semua hanya muncul untuk role 'dekan' -->
        @if (Auth::user() && Auth::user()->role === 'dekan')
            @if ($rooms->contains(fn($room) => $room->status_persetujuan === 'Belum Disetujui'))
                <form method="POST" action="{{ route('rooms.setujuiSemua') }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Setujui Semua
                    </button>
                </form>
            @endif
        @endif
    </div>

    <div class="bg-white shadow-md rounded">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Room ID</th>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Quota</th>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Status</th>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Prodi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $room->nama_ruang }}</td>
                        <td class="py-2 px-4">{{ $room->kuota_ruang }}</td>
                        <td class="py-2 px-4">
                            @if ($room->prodi)
                                <span class="text-orange-500">Occupied</span>
                            @else
                                <span class="text-green-500">Available</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $room->prodi ?? 'Not Assigned' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
