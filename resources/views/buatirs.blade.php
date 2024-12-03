<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik - gaSIAP</title>
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
        font-size: 1.5rem;
        font-weight: bold;
    }
    .filled-cell {
    background-color: #d1fae5; /* Hijau muda */
    font-weight: bold;
    }

    .irs-table {
        background-color: #f0f9ff; /* Biru muda */
    }

    .irs-table {
        margin-top: 20px; /* Margin untuk memastikan ada jarak antara tabel IRS dan konten sebelumnya */
    }



</style>
</head>
<body class="bg-gray-100">
    <header class="header">
        <a href="{{ route('dashboard.mahasiswa') }}" class="text-white text-2xl font-bold">gaSIAP</a>
    </header>

    <div class="container mx-auto px-6 py-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Buat IRS</h2>
    
        <div class="flex space-x-4">
            <!-- Schedule Table -->
            <div class="w-1/2">
                <table class="schedule-table border-collapse border border-gray-300 w-full text-center">
                    <thead>
                        <tr class="bg-gray-200">
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
                                <td class="border border-gray-300">{{ $hour }}:00</td>
                                @for ($day = 1; $day <= 5; $day++)
                                    <td 
                                        class="dropzone border border-gray-300" 
                                        data-day="{{ $day }}" 
                                        data-hour="{{ $hour }}">
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
    
            <!-- Form IRS -->
            <div class="w-1/2 space-y-4">
                <!-- List Mata Kuliah -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">List Mata Kuliah</h3>
                    <div id="matakuliahList">
                        @foreach ($matakuliah as $mk)
                            <div class="draggable bg-green-500 text-white p-2 rounded mb-2" 
                                 draggable="true" 
                                 data-id="{{ $mk->id }}" 
                                 data-name="{{ $mk->nama_matakuliah }}" 
                                 data-sks="{{ $mk->sks }}">
                                {{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS)
                            </div>
                        @endforeach
                    </div>
                </div>
    
                <!-- Tabel Mata Kuliah Ditambahkan -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Mata Kuliah Ditambahkan</h3>
                    <table class="added-courses-table border border-gray-300 w-full text-center">
                        <thead class="bg-gray-200">
                            <tr>
                                <th>Nama</th>
                                <th>SKS</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="addedCourses"></tbody>
                    </table>
                </div>
    
                <!-- Submit Button -->
                <button 
                    class="btn-primary w-full py-2 bg-purple-700 text-white rounded" 
                    onclick="submitSchedule()">
                    Submit IRS
                </button>
            </div>
        </div>
    
        <!-- IRS Section (Pindahkan ke bawah) -->
        <div class="w-full mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">IRS</h3>
            <table class="irs-table border border-gray-300 w-full text-center">
                <thead class="bg-gray-200">
                    <tr>
                        <th>Nama</th>
                        <th>SKS</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody id="irsTable"></tbody>
            </table>
        </div>
    </div>
    

    <script>
        let selectedElement = null;
    
        // Drag & Drop logic
        document.querySelectorAll('.draggable').forEach(item => {
            item.addEventListener('dragstart', (e) => {
                selectedElement = e.target;
            });
        });
    
        document.querySelectorAll('.dropzone').forEach(zone => {
            zone.addEventListener('dragover', (e) => e.preventDefault());
    
            zone.addEventListener('drop', (e) => {
                e.preventDefault();
                const dropzone = e.target.closest('.dropzone');
                const sks = parseInt(selectedElement.getAttribute('data-sks'), 10);
                const day = dropzone.getAttribute('data-day');
                const hour = parseInt(dropzone.getAttribute('data-hour'), 10);
    
                if (checkAvailability(day, hour, sks)) {
                    placeCourseInTable(dropzone, day, hour, sks);
                    saveScheduleToLocalStorage(); // Simpan ke localStorage setelah menambahkan mata kuliah
                } else {
                    alert('Slot not available or SKS exceeds the available time.');
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
    
        function placeCourseInTable(dropzone, day, hour, sks) {
            const courseName = selectedElement.getAttribute('data-name');
            const courseId = selectedElement.getAttribute('data-id');
    
            for (let i = 0; i < sks; i++) {
                const nextCell = document.querySelector(`.dropzone[data-day="${day}"][data-hour="${hour + i}"]`);
                nextCell.classList.add('filled-cell');
                nextCell.setAttribute('data-course', courseName);
                nextCell.innerHTML = courseName; // Tampilkan nama mata kuliah di slot
            }
    
            const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            // Tambahkan mata kuliah ke tabel "Mata Kuliah Ditambahkan"
            const table = document.getElementById('addedCourses');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${courseName}</td>
                <td>${sks}</td>
                <td>${days[day - 1]}</td>
                <td>${hour}:00 - ${hour + sks - 1}:00</td>
                <td><button class="btn text-white p-1 rounded" style="background-color: red;" onclick="removeCourse('${courseName}', ${day}, ${hour}, ${sks})">Hapus</button></td>
            `;
            table.appendChild(row);
        }
    
        // Fungsi untuk menyimpan jadwal kuliah ke localStorage
        function saveScheduleToLocalStorage() {
            const scheduleData = [];
            const daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    
            // Ambil semua cell yang terisi
            document.querySelectorAll('.dropzone.filled-cell').forEach(cell => {
                const day = parseInt(cell.getAttribute('data-day'));
                const hour = parseInt(cell.getAttribute('data-hour'));
                const courseName = cell.getAttribute('data-course');
                const sks = parseInt(cell.getAttribute('data-sks'), 10);
    
                scheduleData.push({ courseName, day, hour, sks });
            });
    
            console.log('Saved Schedule Data:', scheduleData);  // Debugging
    
            // Simpan jadwal kuliah di localStorage
            localStorage.setItem('schedule', JSON.stringify(scheduleData));
    
            // Simpan juga jadwal yang ada di tabel IRS
            const irsData = [];
            document.querySelectorAll('#irsTable tr').forEach(row => {
                const cells = row.querySelectorAll('td');
                const courseName = cells[0].textContent;
                const sks = parseInt(cells[1].textContent, 10);
                const day = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'].indexOf(cells[2].textContent) + 1;
                const hour = parseInt(cells[3].textContent.split(':')[0]);
    
                irsData.push({ courseName, day, hour, sks });
            });
    
            console.log('Saved IRS Data:', irsData);  // Debugging
    
            // Simpan jadwal IRS di localStorage
            localStorage.setItem('irs', JSON.stringify(irsData));
        }
    
        // Fungsi untuk memuat jadwal dari localStorage
        function loadScheduleFromLocalStorage() {
            const savedSchedule = JSON.parse(localStorage.getItem('schedule')) || [];
            const savedIrs = JSON.parse(localStorage.getItem('irs')) || [];
    
            // Load schedule ke tabel dropzone
            savedSchedule.forEach(course => {
                const { courseName, day, hour, sks } = course;
                for (let i = 0; i < sks; i++) {
                    const nextCell = document.querySelector(`.dropzone[data-day="${day}"][data-hour="${hour + i}"]`);
                    nextCell.classList.add('filled-cell');
                    nextCell.setAttribute('data-course', courseName);
                    nextCell.innerHTML = courseName; // Tampilkan nama mata kuliah di slot
                }
            });
    
            // Load IRS ke tabel IRS
            savedIrs.forEach(course => {
                const { courseName, day, hour, sks } = course;
                const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                const table = document.getElementById('irsTable');
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${courseName}</td>
                    <td>${sks}</td>
                    <td>${days[day - 1]}</td>
                    <td>${hour}:00 - ${hour + sks - 1}:00</td>
                `;
                table.appendChild(row);
            });
    
            console.log('Loaded Schedule:', savedSchedule);  // Debugging
            console.log('Loaded IRS:', savedIrs);  // Debugging
        }
    
        // Memanggil fungsi untuk memuat jadwal ketika halaman dimuat
        window.onload = function() {
            loadScheduleFromLocalStorage();
        };
    
        // Fungsi untuk menghapus mata kuliah
        function removeCourse(courseName, day, hour, sks) {
            for (let i = 0; i < sks; i++) {
                const cell = document.querySelector(`.dropzone[data-day="${day}"][data-hour="${hour + i}"]`);
                cell.classList.remove('filled-cell');
                cell.removeAttribute('data-course');
                cell.innerHTML = ''; // Kosongkan kolom
            }
    
            // Hapus dari tabel "Mata Kuliah Ditambahkan"
            const table = document.getElementById('addedCourses');
            Array.from(table.rows).forEach(row => {
                if (row.cells[0].textContent === courseName) {
                    row.remove();
                }
            });
    
            // Simpan kembali jadwal ke localStorage setelah penghapusan
            saveScheduleToLocalStorage();
        }
    
        function submitSchedule() {
            const addedCoursesTable = document.getElementById('addedCourses');
            const irsTable = document.getElementById('irsTable');
    
            // Pindahkan semua row dari "Mata Kuliah Ditambahkan" ke "IRS"
            Array.from(addedCoursesTable.rows).forEach(row => {
                const newRow = row.cloneNode(true);
                newRow.deleteCell(4); // Hapus kolom "Aksi" saat ditambahkan ke IRS
                irsTable.appendChild(newRow);
            });
    
            // Kosongkan tabel "Mata Kuliah Ditambahkan"
            addedCoursesTable.innerHTML = '';
    
            // Simpan jadwal dan IRS ke localStorage
            saveScheduleToLocalStorage();
        }
    
    </script>
</body>
</html>
