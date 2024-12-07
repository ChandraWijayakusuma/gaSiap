<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jadwal Kuliah - gaSIAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Header styles */
    .header {
            background-color: #4a148c;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
    .logo {
        font-size: 1.5rem;
        font-weight: bold;
    }

    /* Schedule table styles */
    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .schedule-table th, .schedule-table td {
        border: 1px solid #ddd;
        text-align: center;
        height: 60px;
        padding: 4px;
        position: relative;
        vertical-align: top;
    }

    .draggable {
        padding: 8px;
        margin: 4px;
        cursor: move;
        background-color: #4caf50;
        color: white;
        border-radius: 4px;
        text-align: center;
    }

    .dropzone {
        min-height: 60px;
    }

    .filled-cell {
        background-color: #e0f7fa;
        border-color: #00897b;
    }

    .delete-btn {
        margin-top: 5px;
        padding: 2px 5px;
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
    }

    /* Modal styles */
    #roomModal {
        z-index: 100;
    }

    .modal-content {
        background-color: #fff;
        padding: 1rem;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Button styles */
    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #7c3aed;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #5c27c5;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
    </style>
</head>
<body class="bg-gray-100">
    <header class="header">
        <a href="{{ route('dashboard.kapro') }}" class="text-white text-2xl font-bold">gaSIAP</a>
    </header>

    <div class="container mx-auto px-6 py-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 flex justify-between items-center">
            <span>Jadwal Kuliah</span>
            @if ($jadwal->isNotEmpty()) 
                <div class="flex justify-end mt-4">
                    <a href="{{ route('lihat.jadwal') }}" class="bg-purple-700 text-white px-4 py-2 rounded">
                        Lihat Hasil Jadwal
                    </a>
                </div>
            @endif
        </h2>
        
        <div class="flex">
            <div class="w-3/4">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Senin</th>
                            <th>Selasa</th>
                            <th>Rabu</th>
                            <th>Kamis</th>
                            <th>Jumat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($hour = 7; $hour <= 18; $hour++)
                            <tr>
                                <td>{{ $hour }}:00</td>
                                @for ($day = 1; $day <= 5; $day++)
                                    <td class="dropzone" data-day="{{ $day }}" data-hour="{{ $hour }}"></td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            
            <div class="w-1/4 ml-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">List Mata Kuliah</h3>
                <div id="matakuliahList">
                    @foreach ($matakuliah as $mk)
                        <div class="draggable" draggable="true" data-id="{{ $mk->id }}" data-name="{{ $mk->nama_matakuliah }}" data-sks="{{ $mk->sks }}">
                            {{ $mk->nama_matakuliah }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="roomModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded shadow-md w-1/3">
            <h3 class="text-lg font-semibold mb-4">Pilih Ruangan</h3>
            <label for="room">Ruangan:</label>
            <select id="roomSelect" class="w-full p-2 border rounded">
                @foreach ($ruangan as $ruang)
                    <option value="{{ $ruang->nama_ruang }}">{{ $ruang->nama_ruang }}</option>
                @endforeach
            </select>

            <div class="flex justify-end mt-4">
                <button onclick="saveRoom()" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                <button onclick="closeModal()" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-4">
        <form id="scheduleForm" method="POST" action="{{ route('submit.jadwal') }}">
            @csrf
            <input type="hidden" name="jadwal" id="jadwalInput">
            <button type="button" onclick="submitSchedule()" class="bg-blue-500 text-white px-4 py-2 rounded">Ajukan Jadwal</button>
        </form>
    </div>

    <script>
        let selectedElement = null;
        let dropzone = null;

        document.querySelectorAll('.draggable').forEach(item => {
            item.addEventListener('dragstart', (e) => {
                selectedElement = e.target;
            });
        });

        document.querySelectorAll('.dropzone').forEach(zone => {
            zone.addEventListener('dragover', (e) => {
                e.preventDefault();
            });

            zone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone = e.target.closest('.dropzone');

                const sks = parseInt(selectedElement.getAttribute('data-sks'), 10);
                const day = dropzone.getAttribute('data-day');
                const hour = parseInt(dropzone.getAttribute('data-hour'), 10);

                if (checkAvailability(day, hour, sks)) {
                    openModal();
                } else {
                    alert('Tidak cukup ruang untuk mata kuliah ini.');
                }
            });
        });

        function checkAvailability(day, hour, sks) {
            for (let i = 0; i < sks; i++) {
                const nextCell = document.querySelector(`.dropzone[data-day="${day}"][data-hour="${hour + i}"]`);
                if (!nextCell || nextCell.childElementCount > 0) {
                    return false;
                }
            }
            return true;
        }

        function saveRoom() {
            const room = document.getElementById('roomSelect').value;
            const sks = parseInt(selectedElement.getAttribute('data-sks'), 10);
            const day = dropzone.getAttribute('data-day');
            const hour = parseInt(dropzone.getAttribute('data-hour'), 10);

            for (let i = 0; i < sks; i++) {
                const nextCell = document.querySelector(`.dropzone[data-day="${day}"][data-hour="${hour + i}"]`);
                if (nextCell) {
                    nextCell.classList.add('filled-cell');
                    if (i === 0) {
                        const newItem = selectedElement.cloneNode(true);
                        newItem.classList.remove('draggable');
                        newItem.innerHTML += 
                            `<div class="text-sm text-gray-600">(${room})</div>
                            <button class="delete-btn" onclick="removeMatakuliah(${day}, ${hour}, ${sks})">Hapus</button>`;
                        newItem.style.height = `${sks * 60}px`;
                        nextCell.appendChild(newItem);
                        nextCell.setAttribute('rowspan', sks);
                    } else {
                        nextCell.style.display = 'none';
                    }
                }
            }
            closeModal();
        }

        function removeMatakuliah(day, hour, sks) {
            for (let i = 0; i < sks; i++) {
                const cell = document.querySelector(`.dropzone[data-day="${day}"][data-hour="${hour + i}"]`);
                if (cell) {
                    cell.classList.remove('filled-cell');
                    cell.style.display = '';
                    cell.innerHTML = '';

                    if (i === 0) {
                        cell.removeAttribute('rowspan');
                    }
                }
            }
        }

        function openModal() {
            document.getElementById('roomModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('roomModal').classList.add('hidden');
        }
        
        function submitSchedule() {
            const submitButton = document.querySelector('button[onclick="submitSchedule()"]');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Menyimpan...';

            const scheduledItems = [];
            
            document.querySelectorAll('.dropzone').forEach(cell => {
                const matakuliah = cell.querySelector('[data-id]');
                if (matakuliah) {
                    const room = matakuliah.textContent.match(/\((.*?)\)/)?.[1] || '';
                    scheduledItems.push({
                        hari: getHariFromNumber(cell.getAttribute('data-day')),
                        jam_mulai: cell.getAttribute('data-hour') + ':00',
                        jam_selesai: (parseInt(cell.getAttribute('data-hour')) + 
                                     parseInt(matakuliah.getAttribute('data-sks'))) + ':00',
                        mata_kuliah_id: matakuliah.getAttribute('data-id'),
                        ruang: room
                    });
                }
            });

            // Don't submit if no courses are scheduled
            if (scheduledItems.length === 0) {
                alert('Silakan tambahkan minimal satu mata kuliah ke jadwal');
                submitButton.disabled = false;
                submitButton.innerHTML = 'Ajukan Jadwal';
                return;
            }

            fetch("{{ route('submit.jadwal') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    jadwal: scheduledItems
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Jadwal berhasil disimpan');
                    updateScheduleUI(scheduledItems);
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan saat menyimpan jadwal');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Terjadi kesalahan saat menyimpan jadwal');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Ajukan Jadwal';
            });
        }

        function updateScheduleUI(scheduledItems) {
        // Clear existing schedule
        document.querySelectorAll('.dropzone').forEach(cell => {
            cell.innerHTML = '';
            cell.classList.remove('filled-cell');
            cell.style.display = '';
            cell.removeAttribute('rowspan');
        });

        // Populate schedule with new data
        scheduledItems.forEach(item => {
            const day = getHariFromNumber(item.hari);
            const startHour = parseInt(item.jam_mulai.split(':')[0], 10);
            const endHour = parseInt(item.jam_selesai.split(':')[0], 10);
            const sks = endHour - startHour;

            for (let hour = startHour; hour < endHour; hour++) {
                const cell = document.querySelector(`.dropzone[data-day="${item.hari}"][data-hour="${hour}"]`);
                if (cell) {
                    cell.classList.add('filled-cell');
                    if (hour === startHour) {
                        const matakuliah = document.createElement('div');
                        matakuliah.innerHTML = `
                            <div data-id="${item.mata_kuliah_id}" data-sks="${sks}">
                                ${getMatakuliahName(item.mata_kuliah_id)}
                                <div class="text-sm text-gray-600">(${item.ruang})</div>
                                <button class="delete-btn" onclick="removeMatakuliah(${item.hari}, ${startHour}, ${sks})">Hapus</button>
                            </div>
                        `;
                        matakuliah.style.height = `${sks * 60}px`;
                        cell.appendChild(matakuliah);
                        cell.setAttribute('rowspan', sks);
                    } else {
                        cell.style.display = 'none';
                    }
                }
            }
        });
    }

        function getHariFromNumber(number) {
            const hariMap = {
                '1': 'Senin',
                '2': 'Selasa',
                '3': 'Rabu',
                '4': 'Kamis',
                '5': 'Jumat'
            };
            return hariMap[number] || '';
        }
    </script>
</body>
</html>