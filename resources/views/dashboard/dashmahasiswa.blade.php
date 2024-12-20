<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - gaSIAP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .header {
            background-color: #4a148c;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
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

        .breadcrumb {
            padding: 1rem 1.5rem;
            color: #6c757d;
        }

        .content {
            padding: 0 1.5rem 1.5rem;
        }

        .content p {
            text-align: left;
        }

        .status {
            padding: 1 1.5rem 1.5rem;
        }

        .status p {
            text-align: center;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .profile-card {
            display: flex;
            align-items: center;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
            flex-shrink: 0;
            transform: translateY(-10px);
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            text-align: left;
        }

        .profile-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-info p {
            margin-bottom: 0.25rem;
            color: #495057;
        }

        .profile-divider {
            border-top: 1px solid #dee2e6;
            margin: 1rem 0;
        }

        .status-card {
            padding: 3.3rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .status-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            margin-top: -1rem;
            color: #343a40;
        }

        .status-dosen {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            text-align: center;
        }

        .status-item {
            padding: 0.5rem;
        }

        .status-item-label {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .status-item-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #212529;
        }

        .text-success {
            color: #28a745;
        }

        .text-warning {
            color: #dc3545;
        }

        .room-section {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            color: inherit;
            margin-bottom: 1.5rem;
        }

        .room-section2 {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            color: inherit;
        }

        .room-icon {
            width: 48px;
            height: 48px;
            background-color: white;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .room-icon img {
            width: 32px;
            height: 32px;
        }

        .room-info h2 {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }

        .room-info p {
            color: #6c757d;
        }

        /* New styles for achievements section */
        .achievements-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin: 1.5rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .achievements-header {
            display: flex;
            justify-content: flex-start;  /* Agar gambar dan teks berada di kiri */
            align-items: center;  /* Menjaga gambar dan teks sejajar secara vertikal */
            margin-bottom: 1rem;
        }

        .achievements-image {
            width: 32px;
            height: 32px;
            margin-right: 20px;
        }

        .achievements-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #343a40;
        }

        .achievement-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .achievement-item {
            background: #f8f9fa;
            padding: 1.25rem;
            border-radius: 0.5rem;
            text-align: center;
        }

        .achievement-label {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .achievement-value {
            font-size: 2rem;
            font-weight: 700;
            color: #4a148c;
        }

        @media (max-width: 768px) {
            .dashboard-cards,
            .achievement-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('dashboard') }}" class="logo">gaSIAP</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <div class="breadcrumb">
        Home / Dashboard
    </div>

    <main class="content">
        <div class="dashboard-cards">
            <!-- Profile Card -->
            <div class="card profile-card">
                <div class="profile-image">
                    <img src="{{ asset('zeus.jpg') }}" alt="Foto Profil">
                </div>
                <div class="profile-info">
                    <h2 class="profile-title">Mahasiswa</h2>
                    <p>Muhammad Zeus</p>
                    <p>24057890210592237</p>
                    <p>m.zeus@students.ac.id</p>
                    <p>zeusmuh@gmail.com</p>
                    <p>081318887988</p>
                    <hr class="profile-divider">
                    <p>Fakultas Petir dan Ilmu Hitam</p>
                    <p>Departemen Ilmu Petir</p>
                </div>
            </div>

            <!-- Status Card -->
            <main class="status">
                <div class="card status-card">
                    <h2 class="status-title">Status Akademik</h2>
                    <p class="status-dosen">
                        Dosen wali: <strong>Haji Thanos, S.IH., M.Pet</strong><br>
                        (NIP: 192020307862024)
                    </p>
                    <div class="status-grid">
                        <div class="status-item">
                            <p class="status-item-label">Semester Akademik Sekarang</p>
                            <p class="status-item-value">2025/2026 Ganjil</p>
                        </div>
                        <div class="status-item">
                            <p class="status-item-label">Semester Studi</p>
                            <p class="status-item-value">{{ $semester }}</p>
                        </div>
                        <div class="status-item">
                            <p class="status-item-label">Status Akademik</p>
                            <p class="status-item-value {{ $statusRegistrasi === 'Aktif' ? 'text-success' : 'text-warning' }}">
                                {{ $statusRegistrasi }}
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Academic Achievements Section -->
        <div class="achievements-card">
            <div class="achievements-header">
                <img src="{{ asset('Trophy.png') }}" alt="Prestasi Akademik" class="achievements-image">
                <h2 class="achievements-title">Prestasi Akademik</h2>
            </div>
        
            <!-- Achievement Stats -->
            <div class="achievement-stats">
                <div class="achievement-item">
                    <p class="achievement-label">IPK (Index Prestasi Kumulatif)</p>
                    <p class="achievement-value">{{ $ipk ?? '0.00' }}</p>
                </div>
                <div class="achievement-item">
                    <p class="achievement-label">SKS (Satuan Kredit Semester)</p>
                    <p class="achievement-value">{{ $sks ?? '18' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Registrasi Akademik -->
        <a href="{{ route('registrasi') }}" class="room-section">
            <div class="room-icon">
                <img src="{{ asset('User.png') }}" alt="Room Icon">
            </div>
            <div class="room-info">
                <h2>Registrasi Administratif</h2>
                <p>Pengajuan Aktif atau Cuti perkuliahan</p>
            </div>
        </a>

        <!-- Akademik -->
        <a href="{{ route('buat.irs') }}" class="room-section2">
            <div class="room-icon">
                <img src="{{ asset('Graduation Cap.png') }}" alt="Room Icon">
            </div>
            <div class="room-info">
                <h2>Akademik</h2>
                <p>TA 2025/2026 Ganjil</p>
            </div>
        </a>
    </main>
</body>
</html>