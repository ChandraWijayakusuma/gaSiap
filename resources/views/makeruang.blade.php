<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms - gaSIAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css" rel="stylesheet">
    <script>
        function confirmPengajuan(event) {
            event.preventDefault(); // Mencegah pengalihan halaman langsung
            const confirmation = confirm("Apakah Anda yakin ingin mengajukan ruangan ini?");
            if (confirmation) {
                // Lanjutkan ke halaman pengajuan jika pengguna mengonfirmasi
                window.location.href = event.target.href;
            }
        }
    </script>
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

<div class="container mx-auto px-6 py-4">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Room Occupancy</h2>

    <!-- Add Room Form -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <h3 class="text-lg font-semibold mb-2">Add Room</h3>
        <form method="POST" action="{{ route('rooms.store') }}">
            @csrf
            <div class="flex space-x-4 mb-4">
                <input type="text" name="nama_ruang" placeholder="Room Name" class="border rounded px-4 py-2 w-full" required>
                <input type="number" name="kuota_ruang" placeholder="Quota" class="border rounded px-4 py-2 w-full" required>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Room</button>
        </form>
    </div>

    <div class="bg-white shadow-md rounded">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Room ID</th>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Quota</th>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Status</th>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Prodi</th>
                    <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-semibold uppercase text-sm">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr class="border-b">
                        <!-- Form Edit Room -->
                        <form method="POST" action="{{ route('rooms.update', $room->id) }}">
                            @csrf
                            @method('PATCH')
                            <td class="py-2 px-4">
                                <input type="text" name="nama_ruang" value="{{ $room->nama_ruang }}" class="border rounded px-2 py-1 w-full">
                            </td>
                            <td class="py-2 px-4">
                                <input type="number" name="kuota_ruang" value="{{ $room->kuota_ruang }}" class="border rounded px-2 py-1 w-full">
                            </td>
                            <td class="py-2 px-4">
                                @if ($room->prodi)
                                    <span class="text-orange-500">Occupied</span>
                                @else
                                    <span class="text-green-500">Available</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                <input type="text" name="prodi" value="{{ $room->prodi }}" placeholder="Enter prodi" class="border rounded px-2 py-1 w-full">
                            </td>
                            <td class="py-2 px-4 flex space-x-2">
                                <button type="submit" class="text-blue-500 hover:text-blue-700">Save</button>
                        </form>
                        
                        <!-- Form Delete Room -->
                        <form method="POST" action="{{ route('rooms.destroy', $room->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                        </form>

                        <!-- Form Clear Prodi -->
                        <form method="POST" action="{{ route('rooms.clearProdi', $room->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-yellow-500 hover:text-yellow-700">Clear</button>
                        </form>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Button Pengajuan Ruang -->
    <div class="mt-6">
        <a href="{{ route('rooms.pengajuan') }}" onclick="confirmPengajuan(event)" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
            Pengajuan Ruang
        </a>
    </div>
</div>

@if(session('success'))
    <script>
        console.log('Success:', "{{ session('success') }}");
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if(session('error'))
    <script>
        console.log('Error:', "{{ session('error') }}");
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonText: 'OK'
        });
    </script>
@endif


</body>
</html>
