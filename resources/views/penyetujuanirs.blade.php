<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Penyetujuan IRS - gaSIAP</title>
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

        .action-btn {
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            color: white;
        }

        .approve-btn {
            background-color: #28a745;
        }

        .approve-btn:hover {
            background-color: #218838;
        }

        .reject-btn {
            background-color: #dc3545;
        }

        .reject-btn:hover {
            background-color: #c82333;
        }

        .detail-btn {
            background-color: #17a2b8;
        }

        .detail-btn:hover {
            background-color: #138496;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="header">
        <a href="{{ route('dashboard') }}" class="logo">gaSIAP</a>
    </header>

    <div class="breadcrumb">
        Home / Verifikasi IRS
    </div>

    <div class="container mx-auto px-6 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Ajuan IRS Mahasiswa</h2>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah SKS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($irsSubmissions as $index => $irs)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $irs->mahasiswa->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $irs->details->sum('matakuliah.sks') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                        <button onclick="showDetail({{ $irs->id }})" class="action-btn detail-btn">
                                            Detail
                                        </button>
                                        <button onclick="approveIRS({{ $irs->id }})" class="action-btn approve-btn">
                                            Setujui
                                        </button>
                                        <button onclick="rejectIRS({{ $irs->id }})" class="action-btn reject-btn">
                                            Tolak
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetail(id) {
            window.location.href = `/penyetujuan-irs/detail/${id}`;
        }

        function approveIRS(id) {
            if (confirm('Apakah Anda yakin ingin menyetujui IRS ini?')) {
                sendAction(id, 'approve');
            }
        }

        function rejectIRS(id) {
            if (confirm('Apakah Anda yakin ingin menolak IRS ini?')) {
                sendAction(id, 'reject');
            }
        }

        function sendAction(id, action) {
            fetch(`/penyetujuan-irs/${action}/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses IRS');
            });
        }
    </script>
</body>
</html>