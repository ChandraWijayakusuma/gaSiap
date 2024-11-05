<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
        /* Mengatur background dengan gambar */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('/background.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        /* Container utama untuk konten login */
        .login-container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px 30px;
            border-radius: 15px;
            width: 350px;
            backdrop-filter: blur(10px);
        }

        /* Gaya judul */
        .login-title {
            font-size: 2.5em;
            font-weight: bold;
            color: white;
            margin-bottom: 20px;
        }

        /* Gaya input login */
        .login-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            text-align: center;
            color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Gaya tombol login */
        .login-button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            font-weight: bold;
            color: white;
            background-color: #4a90e2;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-button:hover {
            background-color: #3d78c6;
        }

        /* Gaya teks link untuk Sign Up */
        .signup-link {
            font-size: 0.9em;
            color: white;
            text-decoration: none;
            margin-top: 10px;
        }

        .signup-link a {
            color: #e74c3c;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* Gaya error */
        .error-message {
            color: #ff4d4d;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-title">gaSIAP</div>
        
        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Input untuk Email/Username -->
            <input type="text" name="email" class="login-input" placeholder="NIM/NIP/username/e-mail" required>
            
            <!-- Input untuk Password -->
            <input type="password" name="password" class="login-input" placeholder="Password" required>
            
            <!-- Pesan Error di bawah Password -->
            @if($errors->has('email') || $errors->has('password'))
                <div class="error-message">Email atau password kosong</div>
            @elseif(session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif
            
            <!-- Tombol login -->
            <button type="submit" class="login-button">Login</button>
        </form>

        <!-- Teks link untuk sign up -->
        <div class="signup-link">
            Belum punya akun? <a href="/register">Sign Up</a>
        </div>
    </div>
</body>
</html>
