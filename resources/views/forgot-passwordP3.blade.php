<!DOCTYPE html>
<html lang="en">
<head>
@vite('resources/css/main.css')
@vite('resources/js/app.js')
<link href="{{ asset('images/colinklogo.png') }}" rel="icon">
<link href="{{ asset('images/colinklogo.png') }}" rel="apple-touch-icon">
<!-- Preconnect for fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- CDN Fonts -->
    <link href="https://fonts.cdnfonts.com/css/andasia" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - CoLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .forgot-password-container {
            display: flex;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .sidebar {
            background-color: #0037B7;
            width: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo {
            color: white;
            font-size: 48px;
            font-weight: bold;
        }
        .forgot-password-form {
            padding: 40px;
            width: 300px;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #ff0000;
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .reset-btn {
            width: 100%;
            padding: 10px;
            background-color: #7B93DB;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <div class="sidebar">
            <div class="logo">Co<br>Link</div>
        </div>
        <div class="forgot-password-form">
        <a href="{{ route('home') }}" class="close-btn" style="font-size: 24px; padding: 10px; color: black; text-decoration: none;">
    &times;
</a>
            <h2>Change Password</h2>
            <form action="{{ route('forgot-passwordP3.post') }}" method="POST">
                @csrf
                <input type="password" name="password" placeholder="Enter password" required>
                <input type="password" name="password_confirmation" placeholder="Confirm password" required>
                <button type="submit" class="reset-btn">Send Reset Code</button>
            </form>
            {{-- <div class="login-link">
                <a href="{{ route('login') }}">Back to Login</a>
            </div> --}}
        </div>
    </div>
</body>
</html>