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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoLink Login</title>

    <style>
        /* Universal Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-size: cover; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px); 
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            position: relative; /* Added for positioning the close button */
            text-align: center;
        }

        .login-container span {
            font-size: 32px;
            font-weight: 600;
            color: #0037B7;
            margin-bottom: 30px;
            display: block;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        .login-form {
            width: 100%;
        }

        .login-form input[type="email"], 
        .login-form input[type="password"] {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 16px;
        }

        .login-form input:focus {
            outline: none;
            border-color: #7B93DB;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #0037B7;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background-color: #0037B7;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #002c91;
        }

        .register-link {
            margin-top: 20px;
        }

        .register-link a {
            color: #0037B7;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .tagline {
            font-size: 14px;
            font-weight: 400;
            color: #555;
            margin-bottom: 10px;
            display: block;
            text-align: center;
        }

        .alert {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Centering the sidebar image */
        .sidebar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 5px; /* Optional: adds spacing below the image */
        }

        .sidebar img {
            width: 120px;
            margin-bottom: 8px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body style="margin: 0; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <!-- Background Layer -->

    <!-- Login Container -->
    <div class="login-container">
        <div class="sidebar">
            <img src="{{ asset('images/coLinklogo.jpg') }}" alt="CoLink Logo">
        </div>
        <div class="tagline">
            Collaborating Breakthrough and Co-elevation!
        </div>
        <div class="login-form">
            <button class="close-btn" onclick="window.location.href='{{ url('/') }}'">&times;</button>

            <h2>Login Now</h2>

            <!-- Display Errors -->
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif

            <!-- Display Session Messages -->
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <input type="email" name="user_email" placeholder="Enter Your Email" required>
                <input type="password" name="password" placeholder="Enter Your Password" required>

                <div class="forgot-password">
                    <a href="{{ route('forgot-passwordP1') }}">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="{{ route('registration') }}">Register</a>
            </div>
        </div>
    </div>
</body>

</html>
