<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lihat IRS - gaSIAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .header {
            background-color: #4a148c;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
        }

        .breadcrumb {
            padding: 1rem 1.5rem;
            color: #6c757d;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: bold;
        }

        .status-belum {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-menunggu {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-disetujui {
            background-color: #d4edda;
            color: #155724;
        }

        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .irs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .irs-table th,
        .irs-table td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
        }

        .irs-table th {
            background-color: #f8fafc;
            font-weight: 600;
        }

        .hapus-btn {
            background-color: #dc3545;
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .hapus-btn:hover {
            background-color: #c82333;
        }

        .ajukan-btn {
            background-color: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .ajukan-btn:hover {
            background-color: #0056b3;
        }

        .kembali-btn {
            background-color: #6c757d;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .kembali-btn:hover {
            background-color: #5a6268;
        }

        .download-btn {
            background-color: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .download-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="header">
        <a href="{{ route('dashboard') }}" class="logo">gaSIAP</a>
    </header>

    <div class="breadcrumb">
        Home / Lihat IRS
    </div>

    <div class="container mx-auto px-6 py-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

<!-- Status dan Tombol Ajukan -->
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">IRS Semester {{ $irs ? $irs->semester : '1' }}</h1>
    <div class="flex items-center space-x-4">
        <span class="status-badge {{ $irs && $irs->status === 'Disetujui' ? 'status-disetujui' : 
               ($irs && $irs->status === 'Menunggu Persetujuan' ? 'status-menunggu' : 
                ($irs && $irs->status === 'Ditolak' ? 'status-ditolak' : 'status-belum')) }}">
            {{ $irs ? $irs->status : 'Belum Disetujui' }}
        </span>
    
        <!-- Add Download PDF button only if approved -->
        @if($irs && $irs->status === 'Disetujui' && $irsDetails->isNotEmpty())
        <a href="{{ route('irs.download-pdf', $irs->id) }}" class="download-btn">
            <img src="download.svg" alt="Print" class="inline-block w-5 h-5 mr-2" />
            Cetak IRS
        </a>
    @endif
    
        @if($irs && $irs->status === 'Belum Disetujui' && $irsDetails->isNotEmpty())
            <form action="{{ route('irs.ajukan', $irs->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="ajukan-btn">
                    Ajukan IRS
                </button>
            </form>
        @endif
    </div>
</div>

            @if($irsDetails->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="irs-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Jadwal</th>
                                <th>Ruangan</th>
                                @if($irs && $irs->status === 'Belum Disetujui')
                                    <th>Aksi</th>
                                @endif
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
                                    @if($irs && $irs->status === 'Belum Disetujui')
                                        <td>
                                            <button onclick="hapusMataKuliah({{ $detail->id }})" class="hapus-btn">
                                                Hapus
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            <tr class="font-bold">
                                <td colspan="2" class="text-right">Total SKS:</td>
                                <td colspan="{{ $irs && $irs->status === 'Belum Disetujui' ? '4' : '3' }}">
                                    {{ $irsDetails->sum('matakuliah.sks') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    Belum ada mata kuliah yang dipilih
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('buat.irs') }}" class="kembali-btn">
                    Kembali ke Buat IRS
                </a>
            </div>
        </div>
    </div>

    <script>
        function hapusMataKuliah(id) {
            if (confirm('Apakah Anda yakin ingin menghapus mata kuliah ini dari IRS?')) {
                fetch(`/irs/delete-matkul/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus mata kuliah');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus mata kuliah');
                });
            }
        }
    </script>
</body>
</html>