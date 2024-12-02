<!DOCTYPE html>  
<html lang="en">  

<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Buat IRS - gaSIAP</title>  
    <style>  
        /* Add your styles here for the page */  
        body {  
            background-color: #f8f9fa;  
            color: #333;  
            font-family: system-ui, -apple-system, sans-serif;  
            margin: 0; /* Ensure consistent margins */  
        }  

        .header {  
            background-color: rgba(74, 20, 140, 1); /* Solid purple for clear visibility */  
            padding: 2rem; /* Added padding for header */  
            position: relative; /* Allow absolute positioning for logo if needed */  
        }  

        .header .logo {  
            font-size: 1.5rem; /* Adjusted logo size */  
            text-decoration: none;  
            color: white; /* Ensure logo text is white */  
            position: absolute; /* Positioning for top left placement */  
            top: 1rem;  /* Vertical alignment */  
            left: 1.5rem; /* Horizontal alignment */  
            font-weight: 700;
        }  

        .nav-tabs {  
            display: flex;  
            justify-content: space-around;  
            background: white;  
            padding: 1rem;  
            margin: 1rem 0;  
            border-bottom: 1px solid #dee2e6;  
        }  

        .nav-tabs button {  
            background-color: #f8f9fa;  
            border: none;  
            padding: 0.5rem 1rem;  
            border-radius: 5px;  
            cursor: default; /* Change cursor to indicate it's not clickable */  
            font-weight: 500;  
        }  

        .nav-tabs button.active {  
            background-color: #6c757d;  
            color: white;  
        }  

        .warning-message {  
            background-color: #f8d7da;  
            color: #721c24;  
            padding: 1rem;  
            text-align: center;  
            margin: 1rem 0;  
            border: 1px solid #f5c6cb;  
            border-radius: 5px;  
        }  

        .irs-form {  
            background: white;  
            padding: 2rem;  
            border-radius: 6px;  
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);  
            margin: 0 1rem;  
        }  

        .irs-form label {  
            display: block;  
            margin-bottom: 0.5rem;  
            font-weight: bold;  
        }  

        .irs-form input,  
        .irs-form select,  
        .irs-form button {  
            width: 100%;  
            padding: 0.5rem;  
            margin-bottom: 1rem;  
            border: 1px solid #ced4da;  
            border-radius: 5px;  
        }  
    </style>  
</head>  

<body>  
    <header class="header">  
        <a href="{{ route('dashboard') }}" class="logo">gaSIAP</a>  
        <!-- Removed logout button -->  
    </header>  

    <div class="nav-tabs">  
        <button class="active">Buat IRS</button>  
        <button>IRS</button>  
        <button>KHS</button>  
        <button>TRANSKRIP</button>  
    </div>  

    <main class="content">  
        <div class="warning-message">  
            Perubahan/pembatalan IRS belum disetujui dosen wali.  
            Silahkan menghubungi dosen wali untuk melakukan perubahan/pembatalan IRS.  
        </div>  

        <div class="irs-form">  
            <h2>Form Buat IRS</h2>  
            <form method="POST" action="{{ route('buat.irs.store') }}">  
                @csrf  

                <label for="course">Mata Kuliah</label>  
                <select id="course" name="course" required>  
                    <option value="">Pilih Mata Kuliah</option>  
                    <option value="matematika">Matematika</option>  
                    <option value="fisika">Fisika</option>  
                    <option value="kimia">Kimia</option>  
                    <!-- Add more options as needed -->  
                </select>  

                <label for="semester">Semester</label>  
                <select id="semester" name="semester" required>  
                    <option value="">Pilih Semester</option>  
                    <option value="1">Semester 1</option>  
                    <option value="2">Semester 2</option>  
                    <option value="3">Semester 3</option>  
                    <!-- Add more options as needed -->  
                </select>  

                <label for="credit_hours">Jumlah SKS</label>  
                <input type="number" id="credit_hours" name="credit_hours" required min="1" placeholder="Masukkan jumlah SKS">  

                <button type="submit">Kirim IRS</button>  
            </form>  
        </div>  
    </main>  
</body>  

</html>