<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Ruang Kelas</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #4CAF50; color: white; text-align: left; }
        .status-kosong { color: red; }
        .status-terisi { color: green; }
    </style>
</head>
<body>
    <h2>Daftar Kelas dan Status Ruang</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Kelas</th>
                <th>Nama Kelas</th>
                <th>Kuota</th>
                <th>Departemen</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelas as $item)
                <tr>
                    <td>{{ $item->kode_kelas }}</td>
                    <td>{{ $item->nama_kelas }}</td>
                    <td>{{ $item->kuota }} orang</td>
                    <td>
                        @if ($item->departemenKelas)
                            {{ $item->departemenKelas->departemen }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="{{ $item->departemenKelas ? 'status-terisi' : 'status-kosong' }}">
                        {{ $item->departemenKelas ? 'Terisi' : 'Kosong' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
