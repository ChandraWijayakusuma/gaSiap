<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat IRS - gaSIAP</title>
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

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .schedule-table th, .schedule-table td {
            border: 1px solid #ddd;
            text-align: center;
            height: 60px;
            padding: 8px;
            position: relative;
            vertical-align: top;
        }

        .matkul-card {
            background-color: #E3F2FD;
            border-radius: 8px;
            padding: 12px;
            margin: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .matkul-card.selected {
            background-color: #90CAF9;
            transform: scale(0.98);
        }

        .matkul-card:hover:not(.bg-gray-300) {
            background-color: #BBDEFB;
        }

        .selected-matkul {
            background-color: #E8F5E9;
            border: 1px solid #A5D6A7;
            border-radius: 8px;
            padding: 12px;
            margin: 8px 0;
        }

        .breadcrumb {
            padding: 1rem 1.5rem;
            color: #6c757d;
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
    </style>
</head>
<body class="bg-gray-100">
    <header class="header">
        <a href="{{ route('dashboard') }}" class="logo">gaSIAP</a>
    </header>

    <div class="breadcrumb">
        Home / Buat IRS
    </div>

    <div class="container mx-auto px-6 py-4">
        <div class="grid grid-cols-1 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Buat IRS</h1>
                    <div>
                        <button onclick="saveIRS()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            Simpan IRS
                        </button>
                    </div>
                </div>

                <!-- Tabel Jadwal -->
                <div class="overflow-x-auto">
                    <table class="schedule-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Jam</th>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                                    <th class="px-4 py-2">{{ $day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @for($hour = 7; $hour <= 17; $hour++)
                                <tr>
                                    <td class="px-4 py-2 bg-gray-50 font-medium">
                                        {{ sprintf('%02d:00', $hour) }}
                                    </td>
                                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                                        @php
                                            $jadwalCell = $jadwal->first(function($j) use ($day, $hour) {
                                                return $j->hari === $day && 
                                                       (int)substr($j->jam_mulai, 0, 2) === $hour;
                                            });
                        
                                            $isSelected = $jadwalCell && in_array($jadwalCell->matakuliah->id, $selectedMatkul);
                                        @endphp
                                        <td>
                                            @if($jadwalCell)
                                                <div class="matkul-card {{ $isSelected ? 'bg-gray-300 cursor-not-allowed' : '' }}" 
                                                     data-id="{{ $jadwalCell->matakuliah->id }}"
                                                     data-jadwal="{{ $jadwalCell->id }}"
                                                     data-nama="{{ $jadwalCell->matakuliah->nama_matakuliah }}"
                                                     data-sks="{{ $jadwalCell->matakuliah->sks }}"
                                                     data-semester="{{ $jadwalCell->matakuliah->semester }}"
                                                     onclick="{{ !$isSelected ? 'selectMatakuliah(this)' : '' }}">
                                                    <div class="font-semibold">{{ $jadwalCell->matakuliah->nama_matakuliah }}</div>
                                                    <div class="text-sm">Semester {{ $jadwalCell->matakuliah->semester }} / {{ $jadwalCell->matakuliah->sks }} SKS</div>
                                                    <div class="text-sm text-gray-600">{{ $jadwalCell->ruangan }}</div>
                                                    @if($isSelected)
                                                        <div class="text-xs text-red-500 mt-1">Sudah dipilih</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <!-- Mata Kuliah yang Dipilih -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Mata Kuliah yang Dipilih</h2>
                    <div id="selected-matkul" class="space-y-2"></div>

                    <!-- Tombol Lihat IRS -->
                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('lihat.irs') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                            Lihat IRS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedMatakuliah = [];
        let existingMatkul = @json($selectedMatkul);
    
        function selectMatakuliah(element) {
            const id = element.dataset.id;
            
            // Cek apakah mata kuliah sudah ada di IRS
            if (existingMatkul.includes(parseInt(id))) {
                return;
            }
    
            const jadwalId = element.dataset.jadwal;
            const nama = element.dataset.nama;
            const sks = element.dataset.sks;
            const semester = element.dataset.semester;
    
            if(element.classList.contains('selected')) {
                element.classList.remove('selected');
                selectedMatakuliah = selectedMatakuliah.filter(mk => mk.id !== id);
            } else {
                element.classList.add('selected');
                selectedMatakuliah.push({
                    id: id,
                    jadwal_id: jadwalId,
                    nama: nama,
                    sks: sks,
                    semester: semester
                });
            }
    
            updateSelectedMatakuliah();
        }
    
        function updateSelectedMatakuliah() {
            const container = document.getElementById('selected-matkul');
            container.innerHTML = '';
    
            selectedMatakuliah.forEach(mk => {
                const div = document.createElement('div');
                div.className = 'selected-matkul';
                div.innerHTML = `
                    <div class="font-semibold">${mk.nama}</div>
                    <div class="text-sm">Semester ${mk.semester} / ${mk.sks} SKS</div>
                    <button onclick="removeMatakuliah('${mk.id}')" class="text-red-600 text-sm mt-2">Hapus</button>
                `;
                container.appendChild(div);
            });
        }
    
        function saveIRS() {
            if(selectedMatakuliah.length === 0) {
                alert('Pilih minimal satu mata kuliah');
                return;
            }
    
            fetch('/irs/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    semester: selectedMatakuliah[0].semester,
                    matakuliah: selectedMatakuliah
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert(data.message);
                    window.location.href = '{{ route("lihat.irs") }}';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan saat menyimpan IRS');
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>