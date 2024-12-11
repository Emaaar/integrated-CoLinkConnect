<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/css/main.css')
    @vite('resources/js/app.js')
    <link href="{{ asset('images/colinklogo.png') }}" rel="icon">
    <link href="{{ asset('images/colinklogo.png') }}" rel="apple-touch-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/andasia" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter the OTP - CoLink</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
                    position: relative; /* Enable positioning for the floating effect */
            background: rgba(240, 240, 240, 0.8); /* Semi-transparent background */
        }
        .floating-form {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            position: relative;
        }
        .floating-form h2 {
            margin-top: 0;
            color: #0037B7;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }
        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #0037B7;
            transition: color 0.3s ease;
        }
        .close-btn:hover {
            color: #ff0000;
        }
        .otp-container {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .otp-input {
            width: 50px;
            height: 60px;
            font-size: 24px;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .otp-input:focus {
            border-color: #0037B7;
            outline: none;
            box-shadow: 0 0 10px rgba(0, 55, 183, 0.3);
        }
        .register-btn {
            width: 100%;
            padding: 15px;
            background-color: #0037B7;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .register-btn:hover {
            background-color: #002a8a;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
        .login-link a {
            color: #0037B7;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .login-link a:hover {
            color: #002a8a;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }
        .alert-danger {
            background-color: #fff5f5;
            border: 1px solid #fed7d7;
            color: #c53030;
        }
        .alert-success {
            background-color: #f0fff4;
            border: 1px solid #c6f6d5;
            color: #2f855a;
        }
        @media (max-width: 768px) {
            .floating-form {
                max-width: 90%;
            }
            .otp-input {
                width: 40px;
                height: 50px;
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="floating-form">
        <a href="{{ route('home') }}" class="close-btn">&times;</a>
        <h2>Enter OTP</h2>

        @if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{$error}}</div>
    @endforeach
@endif

@if (session()->has('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success">{{session('success')}}</div>
@endif

<form action="{{ route('registration-enter-otp.post') }}" method="POST">
    @csrf
    <div class="otp-container">
        <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
        <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
        <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
        <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
        <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
        <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
    </div>
    <button type="submit" class="register-btn">Submit</button>
</form>
            <div class="login-link">
                <a href="{{ route('requestOTP-verifier') }}">Request new OTP</a>
            </div>
    </div>
    </div>
    <script>
        const inputs = document.querySelectorAll('.otp-input');
        
        inputs.forEach((input, index) => {
            input.addEventListener('input', (event) => {
                const value = event.target.value;
                
                if (value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                } else if (value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener('keydown', (event) => {
                if (event.key === 'Backspace' && event.target.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>