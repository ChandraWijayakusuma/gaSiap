<!DOCTYPE html>
<html>
<head>
    <title>IRS Semester {{ $irs->semester }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .student-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total-sks {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
        .status {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Isian Rencana Studi (IRS)</h2>
        <h3>Semester {{ $irs->semester }}</h3>
    </div>

    <div class="student-info">
        <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
        <p><strong>Status:</strong> {{ $irs->status }}</p>
        <p><strong>Dosen Wali:</strong> Haji Thanos, S.IH., M.Pet</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Jadwal</th>
                <th>Ruangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($irsDetails as $detail)
                <tr>
                    <td>{{ $detail->matakuliah->kode_matakuliah }}</td>
                    <td>{{ $detail->matakuliah->nama_matakuliah }}</td>
                    <td>{{ $detail->matakuliah->sks }}</td>
                    <td>{{ $detail->jadwal->hari }}, {{ substr($detail->jadwal->jam_mulai, 0, 5) }} - {{ substr($detail->jadwal->jam_selesai, 0, 5) }}</td>
                    <td>{{ $detail->jadwal->ruangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-sks">
        Total SKS: {{ $totalSKS }}
    </div>
</body>
</html>