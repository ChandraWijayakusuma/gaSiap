<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat IRS - gaSIAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .draggable {
            cursor: pointer;
        }

        .dropzone {
            min-height: 200px;
            border: 2px dashed #ccc;
            padding: 10px;
        }

        .hidden {
            display: none;
        }

        .delete-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="header bg-blue-500 p-4">
        <a href="{{ route('dashboard') }}" class="text-white text-2xl font-bold">gaSIAP</a>
    </header>

    <div class="container mx-auto px-6 py-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Buat IRS</h2>

        <!-- Formulir untuk memilih mata kuliah -->
        <form method="POST" action="{{ route('submit.irs') }}" id="irsForm">
            @csrf
            <div class="mb-4">
                <label for="semester" class="block text-gray-700">Semester Mahasiswa:</label>
                <input type="text" id="semester" name="semester" class="border p-2 w-full" value="{{ $semesterMahasiswa }}" readonly>
            </div>

            <!-- Daftar mata kuliah yang dapat dipilih -->
            <div id="courseList" class="space-y-2 mb-6">
                @foreach ($matakuliah as $mk)
                    <div class="draggable p-2 border bg-white rounded-md flex justify-between items-center" 
                         data-id="{{ $mk->id }}" 
                         data-name="{{ $mk->nama_matakuliah }}" 
                         data-sks="{{ $mk->sks }}" 
                         data-semester="{{ $mk->semester }}">
                        <span>{{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS)</span>
                        <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded" onclick="addToIRS(this)">Tambah</button>
                    </div>
                @endforeach
            </div>

            <!-- Tempat untuk menaruh mata kuliah yang sudah dipilih -->
            <div id="irsDropzone" class="dropzone">
                <h3 class="font-semibold">IRS Anda</h3>
            </div>

            <!-- Peringatan SKS -->
            <div id="skwLimitWarning" class="mt-4 text-red-500 hidden">Jumlah SKS melebihi batas maksimum (24 SKS)!</div>

            <!-- Tombol kirim -->
            <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Kirim IRS</button>
        </form>
    </div>

    <script>
        let totalSKS = 0;  // Total SKS yang telah dipilih
        const maxSKS = 24;  // Maksimal SKS
        const selectedSemester = parseInt('{{ $semesterMahasiswa }}');  // Semester mahasiswa saat ini

        // Menambahkan mata kuliah ke IRS
        function addToIRS(button) {
            const mataKuliah = button.closest('.draggable');
            const sks = parseInt(mataKuliah.getAttribute('data-sks'), 10);
            const semester = parseInt(mataKuliah.getAttribute('data-semester'), 10);

            // Prioritaskan mata kuliah yang sesuai dengan semester
            if (semester > selectedSemester) {
                alert('Mata kuliah ini tidak boleh diambil karena bukan mata kuliah prioritas.');
                return;
            }

            // Cek batas SKS
            if (totalSKS + sks > maxSKS) {
                document.getElementById('skwLimitWarning').classList.remove('hidden');
                return;
            } else {
                document.getElementById('skwLimitWarning').classList.add('hidden');
            }

            // Cek bentrok jadwal
            if (checkScheduleConflict()) {
                if (confirm('Jadwal ini bertabrakan dengan jadwal lain. Apakah Anda ingin mengganti jadwal?')) {
                    removeConflictingSchedule();
                } else {
                    return; // Batalkan penambahan mata kuliah
                }
            }

            // Tambahkan mata kuliah ke IRS
            const newItem = mataKuliah.cloneNode(true);
            newItem.classList.remove('draggable');  // Menghapus kelas draggable
            newItem.innerHTML += 
                `<button class="delete-btn" onclick="removeMatakuliah(this)">Hapus</button>`;
            document.getElementById('irsDropzone').appendChild(newItem);

            totalSKS += sks;  // Update total SKS yang telah dipilih
        }

        // Menghapus mata kuliah dari IRS
        function removeMatakuliah(button) {
            const sks = parseInt(button.parentElement.getAttribute('data-sks'), 10);
            totalSKS -= sks;  // Update total SKS saat mata kuliah dihapus
            button.parentElement.remove();
            if (totalSKS <= maxSKS) {
                document.getElementById('skwLimitWarning').classList.add('hidden');  // Sembunyikan peringatan jika SKS sudah sesuai
            }
        }

        // Mengecek bentrok jadwal (implementasikan sesuai kebutuhan)
        function checkScheduleConflict() {
            // Misalnya, jika ada jadwal yang bertabrakan, Anda bisa kembalikan nilai true
            return false;  // Contoh: tidak ada bentrok
        }

        // Menghapus jadwal yang bentrok (implementasikan sesuai kebutuhan)
        function removeConflictingSchedule() {
            // Implementasikan logika untuk menghapus jadwal yang bentrok
        }
    </script>
</body>
</html>
