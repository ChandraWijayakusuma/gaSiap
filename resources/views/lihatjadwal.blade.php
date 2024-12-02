<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>Penyetujuan Jadwal - gaSIAP</title>
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

       .filled-cell {
           background-color: #e0f7fa;
           border-color: #00897b;
           padding: 8px;
       }

       /* Tinggi cell berdasarkan SKS */
       .sks-1 { height: 60px; }
       .sks-2 { height: 120px; }
       .sks-3 { height: 180px; }
       .sks-4 { height: 240px; }

       .status-pending {
           background-color: #fff3cd;
       }

       .status-approved {
           background-color: #d4edda;
       }

       .matkul-info {
           margin-bottom: 4px;
           font-weight: 500;
       }

       .room-info {
           font-size: 0.875rem;
           color: #4b5563;
       }

       .status-text {
           font-size: 0.75rem;
           margin-top: 4px;
       }

       .dropzone {
           min-height: 60px;
       }

       /* Custom class for background based on status */
       .status-jadwal {
           padding: 8px 16px; /* Padding seperti tombol */
           border-radius: 8px; /* Rounded corners */
           font-weight: bold;  /* Font bold untuk penekanan */
           display: inline-block; /* Agar terlihat seperti tombol */
           color: white; /* Teks putih */
           text-align: center; /* Rata tengah */
           cursor: pointer; /* Menunjukkan elemen bisa diklik */
       }

       .status-disetujui {
           background-color: #28a745; /* Green */
       }

       .status-belum-disetujui {
           background-color: #dc3545; /* Red */
       }
   </style>
</head>
<body class="bg-gray-100">
   <header class="header">
       <a href="{{ route('dashboard.kapro') }}" class="text-white text-2xl font-bold">gaSIAP</a>
   </header>

   <div class="container mx-auto px-6 py-4">
       <div class="flex justify-between items-center mb-4">
           <h2 class="text-2xl font-semibold text-gray-700">Hasil Jadwal</h2>
           <div class="space-x-2">
               <div class="status-jadwal 
                   @if($statusJadwal == 'Disetujui') 
                       status-disetujui 
                   @else 
                       status-belum-disetujui 
                   @endif">
                   <p>{{ $statusJadwal }}</p>
               </div>
           </div>
       </div>

       @if(session('success'))
           <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
               {{ session('success') }}
           </div>
       @endif

       <div class="w-full">
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
                           @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                               @php
                                   $jadwalCell = $jadwal->first(function($j) use ($day, $hour) {
                                       return $j->day === $day && 
                                              (int)substr($j->jam_mulai, 0, 2) === $hour;
                                   });

                                   $isPartOfRowspan = $jadwal->first(function($j) use ($day, $hour) {
                                       $jamMulai = (int)substr($j->jam_mulai, 0, 2);
                                       $jamSelesai = (int)substr($j->jam_selesai, 0, 2);
                                       return $j->day === $day && $hour > $jamMulai && $hour < $jamSelesai;
                                   });
                               @endphp

                               @if($isPartOfRowspan)
                                   {{-- Biarkan kosong untuk cell yang tergabung dalam rowspan --}}
                                   @continue
                               @endif

                               <td 
                                   @if($jadwalCell)
                                       rowspan="{{ (int)substr($jadwalCell->jam_selesai, 0, 2) - (int)substr($jadwalCell->jam_mulai, 0, 2) }}"
                                   @endif
                               >
                                   @if($jadwalCell)
                                       <div class="filled-cell {{ $jadwalCell->status === 'Setujui' ? 'status-approved' : 'status-pending' }} sks-{{ $jadwalCell->matakuliah->sks }}">
                                           <div class="matkul-info">{{ $jadwalCell->matakuliah->nama_matakuliah }}</div>
                                           <div class="room-info">({{ $jadwalCell->room }})</div>
                                           <div class="status-text">
                                               {{ $jadwalCell->status }}
                                           </div>
                                       </div>
                                   @endif
                               </td>
                           @endforeach
                       </tr>
                   @endfor
               </tbody>
           </table>
       </div>

       @if($jadwal->isEmpty())
           <div class="text-center py-4 text-gray-500">
               Tidak ada jadwal yang perlu disetujui
           </div>
       @endif
   </div>
</body>
</html>
