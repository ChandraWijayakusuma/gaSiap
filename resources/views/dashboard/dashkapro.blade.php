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

        .status-card h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            text-align: center;
        }

        .status-item-label {
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .status-item-value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .status-item-value.verifikasi {
            color: #28a745; /* Hijau */
        }

        .status-item-value.belum-verifikasi {
            color: #dc3545; /* Merah */
        }

        .room-section {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            margin-top: 1.5rem;
            color: inherit;
            text-decoration: none;
        }

        .room-section img {
            width: 32px;
            height: 32px;
            margin-right: 1rem;
        }

        .room-section h2 {
            font-size: 1.25rem;
        }

        .room-section p {
            color: #6c757d;
        }

        .status-jadwal {
            margin-top: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('dashboard.kapro') }}" class="logo">gaSIAP</a>
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
                    <img src="{{ asset('mbpe.jpg') }}" alt="Foto Profil">
                </div>
                <div class="profile-info">
                    <h2 class="profile-title">Ketua Program Studi</h2>
                    <p>Mbappe Al Ansor</p>
                    <p>12023245067807</p>
                    <p>mbpee.s@lecturer.ac.id</p>
                    <p>zimbape@gmail.com</p>
                    <p>081924667834</p>
                    <hr class="profile-divider">
                    <p>Fakultas Petir dan Ilmu Hitam</p>
                    <p>Departemen Ilmu Petir</p>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card status-card">
                <h2>Status Jadwal</h2>

                <!-- Status Jadwal Mata Kuliah -->
                <div class="status-jadwal">
                    <p class="status-item-label" style="margin-bottom: 0.5rem;">Status Jadwal Mata Kuliah</p>
                    <p class="status-item-value {{ $statusJadwal == 'Disetujui' ? 'verifikasi' : 'belum-verifikasi' }}">
                        {{ $statusJadwal }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Room Section as a clickable link -->
        <a href="{{ route('jadwalkuliah') }}" class="room-section">
        <div class="room-icon">
            <img src="{{ asset('calan.png') }}" alt="Room Icon">
        </div>
        <div class="room-info">
            <h2>Jadwal Kuliah</h2>
            <p>Pengaturan Penempatan Matakuliah</p>
        </div>
    </a>
    </main>
</body>
</html>
