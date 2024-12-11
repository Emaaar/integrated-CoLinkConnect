<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/css/main.css')
    @vite('resources/js/app.js')

    <link href="{{ asset('images/colinklogo.png') }}" rel="icon">
    <link href="{{ asset('images/colinklogo.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - CoLink</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .forgot-password-container {
            width: 100%;
            max-width: 360px;
            background-color: #fff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .forgot-password-container h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .forgot-password-container p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .forgot-password-container input[type="email"] {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 16px;
        }

        .forgot-password-container input:focus {
            outline: none;
            border-color: #7B93DB;
        }

        .reset-btn {
            width: 100%;
            padding: 14px;
            background-color: #0037B7;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .reset-btn:hover {
            background-color: #002c91;
        }

        .login-link {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        .login-link a {
            color: #0037B7;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <h2>Forgot Password</h2>
        <p>Enter your email address to receive a reset code.</p>

        <form action="{{ route('forgot-passwordP1.post') }}" method="POST">
            @csrf
            <input type="email" name="user_email" placeholder="Enter Your Email" required>
            <button type="submit" class="reset-btn">Send Reset Code</button>
        </form>

        <div class="login-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</body>
</html>