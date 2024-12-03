<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jadwal Kuliah - gaSIAP</title>
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

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .schedule-table th, .schedule-table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 4px;
            position: relative;
            vertical-align: top;
            min-height: 60px;
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
            vertical-align: top;
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

        .modal-content {
            background-color: #fff;
            padding: 1rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
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

        .draggable {
            cursor: grab;
        }

        .draggable:active {
            cursor: grabbing;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="header">
        <a href="{{ route('dashboard.kapro') }}" class="text-white text-2xl font-bold">gaSIAP</a>
    </header>

    <div class="container mx-auto px-6 py-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 flex justify-between items-center">
            <span>Buat IRS</span>
        </h2>

        <div class="flex">
            <!-- Schedule Table -->
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
            
            <!-- Course List -->
            <div class="w-1/4 ml-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">List Mata Kuliah</h3>
                <div id="matakuliahList">
                    @foreach ($matakuliah as $mk)
                        <div class="draggable" draggable="true" data-id="{{ $mk->id }}" data-name="{{ $mk->nama_matakuliah }}" data-sks="{{ $mk->sks }}">
                            {{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS)
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedElement = null;

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
                const dropzone = e.target.closest('.dropzone');
                const sks = parseInt(selectedElement.getAttribute('data-sks'), 10);
                const day = dropzone.getAttribute('data-day');
                const hour = parseInt(dropzone.getAttribute('data-hour'), 10);

                if (checkAvailability(day, hour, sks)) {
                    placeCourseInTable(dropzone, day, hour, sks);
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
            for (let i = 0; i < sks; i++) {
                const nextCell = document.querySelector(`.dropzone[data-day="${day}"][data-hour="${hour + i}"]`);
                nextCell.classList.add('filled-cell');
                nextCell.innerHTML = selectedElement.innerHTML;
                nextCell.setAttribute('data-course', selectedElement.getAttribute('data-name'));
                nextCell.setAttribute('data-sks', sks);
            }

            // After dropping, clear the dragged item to reset for new drags
            selectedElement = null;
        }

        function submitSchedule() {
            const schedule = [];
            document.querySelectorAll('.dropzone').forEach(zone => {
                if (zone.innerHTML !== '') {
                    schedule.push({
                        day: zone.getAttribute('data-day'),
                        hour: zone.getAttribute('data-hour'),
                        course: zone.getAttribute('data-course'),
                        sks: zone.getAttribute('data-sks')
                    });
                }
            });
            console.log(schedule); // This could be a form submission or an AJAX call to save the schedule
        }
    </script>
</body>
</html>
