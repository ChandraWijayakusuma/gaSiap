<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - gaSIAP</title>
    <style>
        /* Style umum untuk dashboard */
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
        }

        .breadcrumb {
            padding: 1rem 1.5rem;
            color: #6c757d;
        }

        .content {
            padding: 0 1.5rem 1.5rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="#" class="logo">gaSIAP</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <div class="breadcrumb">Home / Dashboard</div>

    <main class="content">
        <!-- Menampilkan dashboard berdasarkan role -->
        @switch($role)
            @case('dekan')
                @include('dashboard.dashdekan')
                @break

            @case('BA')
                @include('dashboard.dashba')
                @break

            @case('kapro')
                @include('dashboard.dashkapro')
                @break

            @case('user')
                @include('dashboard.dashuser')
                @break

            @case('dosen')
                @include('dashboard.dashdosen')
                @break

            @case('mahasiswa')
                @include('dashboard.dashmahasiswa')
                @break

            @default
                <p>Role tidak ditemukan</p>
        @endswitch
    </main>
</body>
</html>
