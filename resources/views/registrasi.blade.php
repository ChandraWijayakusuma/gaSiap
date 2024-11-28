<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Administratif - gaSIAP</title>
    <style>
        /* Tambahkan gaya dari desain Anda di sini */
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

        .container {
            padding: 1.5rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .options {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
            cursor: pointer;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .card h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .card p {
            margin-bottom: 1rem;
            color: #6c757d;
        }

        .card button {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .profile-divider {
            border-top: 1px solid #dee2e6;
            margin: 1rem 0;
        }

        .aktif-btn {
            background-color: #4a148c;
            color: white;
        }

        .aktif-btn:hover {
            background-color: #370b6a;
        }

        .cuti-btn {
            background-color: #dc3545;
            color: white;
        }

        .cuti-btn:hover {
            background-color: #b02a37;
        }

        .st-akademik h2 {
            font-size: 1.25rem;
            margin-bottom: 0.05rem;
        }

        .st-akademik {
            padding: 0 0.1rem 1.5rem;
        }

        .st-akademik p {
            text-align: left;
        }

        .st-akademik p {
            color: #6c757d;
        }

        .room-icon {
            width: 60px;
            height: 60px;
            background-color: #e9ecef;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .room-icon img {
            width: 100px;
            height: 100px;
        }

        .status-display {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: left;
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

    <div class="container">
        <div class="title">Registrasi Administratif</div>

        <!-- Pilihan Status -->
        <div class="options">
            <form method="POST" action="{{ route('registrasi.update') }}" class="card">
                <div class="room-icon">
                    <img src="{{ asset('Childrens Backpack.png') }}" alt="Room Icon">
                </div>
                @csrf
                <h2>Aktif</h2>
                <p>Anda akan mengikuti kegiatan perkuliahan pada semester ini serta mengisi Isian Rencana Studi (IRS).</p>
                <hr class="profile-divider">
                <button type="submit" name="status" value="Aktif" class="aktif-btn">Aktif</button>
            </form>

            <form method="POST" action="{{ route('registrasi.update') }}" class="card">
                <div class="room-icon">
                    <img src="{{ asset('Beach.png') }}" alt="Room Icon">
                </div>
                @csrf
                <h2>Cuti</h2>
                <p>Menghentikan kuliah sementara untuk semester ini tanpa kehilangan status sebagai mahasiswa Undip.</p>
                <hr class="profile-divider">
                <button type="submit" name="status" value="Cuti" class="cuti-btn">Cuti</button>
            </form>
        </div>

        <!-- Status Akademik -->
        <div class="status-display">
            <div class="st-akademik">
                <h2>Registrasi Administrasi</h2>
            </div>
            <p>Status akademik: <strong>{{ session('statusAkademik', $statusAkademik) }}</strong></p>
        </div>
    </div>
</body>
</html>
