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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - CoLink</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
        }
        .forgot-password-container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .forgot-password-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .forgot-password-content h4 {
            margin-bottom: 1.5rem;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 16px;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #7B93DB;
        }
        .register-btn {
            padding: 0.75rem 2rem;
            background-color: #0037B7;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 1.5rem;
            transition: background-color 0.3s;
        }
        .register-btn:hover {
            background-color: #0050e6;
        }
        .login-link {
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        .login-link a {
            color: #0037B7;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
            text-align: left;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .otp-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        .otp-input {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
        }
        .otp-input:focus {
            border-color: #0037B7;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <div class="forgot-password-content">
            <h4>Enter the Password Reset Code</h4>

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

            <form action="{{ route('forgot-passwordP2.post') }}" method="POST">
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
                <a href="{{ route('requestOTP-reset') }}">Request new OTP</a>
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