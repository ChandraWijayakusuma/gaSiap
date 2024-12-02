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
            padding: 1 1.5rem 2rem;
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
            padding: 3rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .status-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
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
            text-decoration: none; /* Hilangkan underline pada tautan */
            color: inherit; /* Warna teks mengikuti warna default */
        }

        .room-section2 {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-decoration: none; /* Hilangkan underline pada tautan */
            color: inherit; /* Warna teks mengikuti warna default */
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

        @media (max-width: 768px) {
            .dashboard-cards {
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
                    <img src="{{ asset('thanos.jpg') }}" alt="Foto Profil">
                </div>
                <div class="profile-info">
                    <h2 class="profile-title">Pembimbing Akademik</h2>
                    <p>Haji Thanos</p>
                    <p>158395020245</p>
                    <p>thanos@lecturer.ac.id</p>
                    <p>h.thanos@gmail.com</p>
                    <p>081388881363</p>
                    <hr class="profile-divider">
                    <p>Fakultas Petir dan Ilmu Hitam</p>
                    <p>Departemen Ilmu Petir</p>
                </div>
            </div>

            <!-- Status Card -->
            <main class="status">
                <div class="card status-card">
                    <h2 class="status-title">Status Pembimbing Akademik</h2>
                    <div class="status-grid">
                        <div class="status-item">
                            <p class="status-item-label">Status Pengajar</p>
                            <p class="status-item-value">Aktif</p>
                        </div>
                        <div class="status-item">
                            <p class="status-item-label">Dokumen Verified</p>
                            <p class="status-item-value">25</p>
                        </div>
                        <div class="status-item">
                            <p class="status-item-label">Jumlah Dokumen</p>
                            <p class="status-item-value">100</p>
                        </div>
                    </div>
                </div>
                    </div>
        
        <!-- Registrasi Akademik as a clickable link -->
        <div class="room-cards">
            <a href="{{ route('registrasi') }}" class="room-section">
                <div class="room-icon">
                    <img src="{{ asset('document.png') }}" alt="Room Icon">
                </div>
                <div class="room-info">
                    <h2>IRS</h2>
                    <p>Verifikasi IRS</p>
                </div>
            </a>
        </div>
    </main>
</body>
</html>