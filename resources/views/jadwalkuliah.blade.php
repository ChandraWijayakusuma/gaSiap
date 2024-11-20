<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah - gaSIAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
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
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-purple-700 p-4 flex justify-between items-center">
        <a href="{{ route('dashboard.kapro') }}" class="text-white text-2xl font-bold">gaSIAP</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Logout</button>
        </form>
    </header>

    <div class="container mx-auto px-6 py-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Jadwal Kuliah</h2>
        
        <div class="flex">
            <!-- Jadwal Table -->
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
            
            <!-- List Mata Kuliah -->
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

    <!-- Modal for Room Selection -->
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
        <form method="POST" action="{{ route('submit.jadwal') }}">
            @csrf
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Ajukan Jadwal</button>
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
            dropzone = e.target;

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
                    newItem.innerHTML += `
                        <div class="text-sm text-gray-600">(${room})</div>
                        <button class="delete-btn" onclick="removeMatakuliah(${day}, ${hour}, ${sks})">Hapus</button>`;
                    newItem.style.height = `${sks * 60}px`; // Sesuaikan tinggi elemen
                    nextCell.appendChild(newItem);
                    nextCell.setAttribute('rowspan', sks); // Gabungkan sel
                } else {
                    nextCell.style.display = 'none'; // Sembunyikan sel lainnya
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
            cell.style.display = ''; // Tampilkan kembali jika disembunyikan
            cell.innerHTML = ''; // Kosongkan isi sel

            // Jika ini adalah sel pertama, hapus atribut rowspan
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
    
    function saveSchedule(day, hour, matakuliahId, room) {
        const data = {
            day: day,
            hour: hour,
            matakuliah_id: matakuliahId,
            room: room,
            _token: "{{ csrf_token() }}"
        };

        fetch("{{ route('submit.jadwal') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Jadwal berhasil disimpan.");
            } else {
                alert("Gagal menyimpan jadwal.");
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>


</body>
</html>