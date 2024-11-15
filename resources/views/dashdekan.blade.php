<!DOCTYPE html>
<html lang="en">
@if ($role === 'dosen')
    <>
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

            /* Breadcrumb */
            .breadcrumb {
                padding: 1rem 1.5rem;
                color: #6c757d;
            }

            /* Main Content */
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

            /* Profile Card */
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
                transform: translateY(-10px); /* Mengangkat gambar sedikit ke atas */
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

            /* Status Card */
            .status-card h2 {
                font-size: 1.25rem;
                margin-bottom: 1rem;
            }

            .faculty-name {
                color: #495057;
                margin-bottom: 1.5rem;
            }

            .status-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
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
                color: #212529;
            }

            /* Room Section */
            .room-section {
                background: white;
                border-radius: 0.5rem;
                padding: 1.5rem;
                display: flex;
                align-items: center;
                gap: 1.5rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .room-icon {
                width: 48px;
                height: 48px;
                background-color: #e9ecef;
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
            <a href="#" class="logo">gaSIAP</a>
            <button class="logout-btn">Logout</button>
        </header>

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            Home / Dashboard
        </div>

        <!-- Main Content -->
        <main class="content">
            <div class="dashboard-cards">
                <!-- Profile Card -->
                <div class="card profile-card">
                    <div class="profile-image">
                        <img src="{{ asset('arsyad.png') }}" alt="Foto Profil">
                    </div>
                    <div class="profile-info">
                        <h2 class="profile-title">Dosen</h2>
                        <p>Kanz Alip</p>
                        <p>12023245067707</p>
                        <p>kanzalip@lecturer.ac.id</p>
                        <p>kanzalip28@gmail.com</p>
                        <p>081389047689</p>
                        <hr class="profile-divider">
                        <p>Fakultas Petir dan Ilmu Hitam</p>
                        <p>Departemen Ilmu Petir</p>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card status-card">
                    <h2>Status Ruang</h2>
                    <p class="faculty-name">Fakultas: Petir dan Ilmu Hitam</p>
                    <div class="status-grid">
                        <div>
                            <p class="status-item-label">Total Kelas</p>
                            <p class="status-item-value">20</p>
                        </div>
                        <div>
                            <p class="status-item-label">Kelas Terisi</p>
                            <p class="status-item-value">14</p>
                        </div>
                        <div>
                            <p class="status-item-label">Kelas Tidak Terisi</p>
                            <p class="status-item-value">6</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Section -->
            <div class="room-section">
                <div class="room-icon">
                    <img src="{{ asset('house.png') }}" alt="Room Icon">
                </div>
                <div class="room-info">
                    <h2>RUANG</h2>
                    <p>Pengaturan Ketersediaan Ruang dan Kuota Ruang</p>
                </div>
            </div>
        </main>
        
    </body>
@elseif ($role === 'dekan')
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

        /* Header Styles */
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

        /* Breadcrumb */
        .breadcrumb {
            padding: 1rem 1.5rem;
            color: #6c757d;
        }

        /* Main Content */
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

        /* Profile Card */
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
            transform: translateY(-10px); /* Mengangkat gambar sedikit ke atas */
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

        /* Status Card */
        .status-card h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .faculty-name {
            color: #495057;
            margin-bottom: 1.5rem;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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
            color: #212529;
        }

        /* Room Section */
        .room-section {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .room-icon {
            width: 48px;
            height: 48px;
            background-color: #e9ecef;
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
        <a href="#" class="logo">gaSIAP</a>
        <button class="logout-btn">Logout</button>
    </header>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        Home / Dashboard
    </div>

    <!-- Main Content -->
    <main class="content">
        <div class="dashboard-cards">
            <!-- Profile Card -->
            <div class="card profile-card">
                <div class="profile-image">
                    <img src="{{ asset('paruq.png') }}" alt="Foto Profil">
                </div>
                <div class="profile-info">
                    <h2 class="profile-title">Dekan</h2>
                    <p>Erje Pitu</p>
                    <p>12023245067807</p>
                    <p>alma.s@edumind.ac.id</p>
                    <p>almasiumintak@gmail.com</p>
                    <p>081924667834</p>
                    <hr class="profile-divider">
                    <p>Fakultas Petir dan Ilmu Hitam</p>
                    <p>Departemen Ilmu Petir</p>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card status-card">
                <h2>Status Ruang</h2>
                <p class="faculty-name">Fakultas: Petir dan Ilmu Hitam</p>
                <div class="status-grid">
                    <div>
                        <p class="status-item-label">Total Kelas</p>
                        <p class="status-item-value">20</p>
                    </div>
                    <div>
                        <p class="status-item-label">Kelas Terisi</p>
                        <p class="status-item-value">14</p>
                    </div>
                    <div>
                        <p class="status-item-label">Kelas Tidak Terisi</p>
                        <p class="status-item-value">6</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Section -->
        <div class="room-section">
            <div class="room-icon">
                <img src="{{ asset('house.png') }}" alt="Room Icon">
            </div>
            <div class="room-info">
                <h2>RUANG</h2>
                <p>Pengaturan Ketersediaan Ruang dan Kuota Ruang</p>
            </div>
        </div>
    </main>
    </body>
@else
    <p>Role tidak ditemukan</p>
@endif
</html>