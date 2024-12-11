<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;

// Set the default timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

class AuthManager extends Controller {
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if the email is in the admin table first
        $admin = Admin::where('aduser_email', $request->user_email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            session(['admin_email' => $admin->aduser_email]);
            return redirect()->route('admin-dash');
        }

        // Check if the email is in the user table
        $user = User::where('user_email', $request->user_email)->first();

        if (!$user) {
            return redirect()->route('login')->with("error", "User not found!");
        }

        if ($user->otp !== null) {
            session(['user_email' => $request->user_email]);
            return redirect()->route('registration-enter-otp')->with('warning', 'Your email is not verified. Please enter the OTP sent to your email.');
        }

        // Use the 'web' guard explicitly for user authentication
        if (Auth::guard('web')->attempt(['user_email' => $request->user_email, 'password' => $request->password])) {
            session(['user_email' => $request->user_email]);
            return redirect()->intended(route('home'));
        }

        return redirect()->route('login')->with("error", "Invalid credentials!");
    }

    public function registration(){
        if(Auth::check()){
            return redirect(route('home'));
        }
        return view(view:'registration');
    }

   
    public function registrationPost(Request $request) {
        // Set the default timezone to Asia/Manila
        date_default_timezone_set('Asia/Manila');

        // Validate the input
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'user_email' => 'required|email|unique:users,user_email',
            'organization' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ], ['password_confirmation.same' => 'Password does not match.']);

        // Generate OTP and set creation time
        $otp = mt_rand(100000, 999999);
        $otp_created_at = Carbon::now(); // This will now use the Asia/Manila timezone

        // Prepare the user data
        $data = [
            'user_email' => $request->user_email,
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'organization' => $request->organization,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'otp_created_at' => $otp_created_at // Store OTP creation time
        ];

        session(['user_email' => $request->user_email]);

        // Send OTP email
        $mail = new PHPMailer(true);
        try {
            // Mail server settings
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username = getenv('MAIL_USERNAME');
            $mail->Password = getenv('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = getenv('SMTP_PORT');

            // Recipients
            $mail->setFrom('arlonielockon@gmail.com', 'Mailer');
            $mail->addAddress($request->user_email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verifier OTP';
            $mail->Body    = 'Your email verifier OTP is: ' . $otp . ' (it is only valid for 1 minute)';

            $mail->send();

            // Create the user with OTP and time of creation
            $user = User::create($data);

            // Check if the user is created successfully
            if (!$user) {
                return redirect(route('registration'))->with("error", "Registration failed, please try again.");
            }

            // Redirect to the OTP input page
            return redirect(route('registration-enter-otp'))->with('success', 'Registration successful! Please check your email for the OTP.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }

    public function registration_enterOTP(){
        if(Auth::check()){
            return redirect(route('home'));
        }
        return view(view:'registration-enterOTP');
    }
    public function registration_enterOTP_Post(Request $request)
    {
        // Set the default timezone to Asia/Manila
        date_default_timezone_set('Asia/Manila');
    
        // If OTP is sent as an array, combine it into a single string
        if (is_array($request->otp)) {
            $request->merge(['otp' => implode('', $request->otp)]);
        }
    
        // Validate the input OTP
        $request->validate([
            'otp' => 'required|digits:6',
        ]);
    
        // Retrieve the user by OTP
        $user = User::where('otp', $request->otp)->first();
    
        // Check if the user exists
        if (!$user) {
            return redirect()->route('registration-enter-otp')->with('error', 'The OTP is incorrect.');
        }
    
        // Check if the OTP has expired (1 minute)
        $otpCreatedAt = Carbon::parse($user->otp_created_at);
        if ($otpCreatedAt->diffInMinutes(Carbon::now()) > 1) {
            return redirect()->route('registration-enter-otp')->with('error', 'OTP has expired. Please request a new one.');
        }
    
        // OTP is valid and not expired, clear the OTP and mark the email as verified
        $user->otp = null;
        $user->otp_created_at = null; // Clear the timestamp
        $user->save();
    
        // Log the user in
        Auth::guard('web')->login($user);
    
        return redirect()->route('home')->with('success', 'OTP verified successfully. You are now logged in.');
    }
    



    public function forgot_passwordP1(){
        return view(view:'forgot-passwordP1');
    }
    public function forgot_passwordP1Post(Request $request){
        // Validate the request
        $request->validate([
            'user_email' => 'required|email'
        ]);

        // Retrieve the user by email
        $user = User::where('user_email', $request->user_email)->first();

        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with("error", "User not found!"); // Stay on the forgot password page with an error
        }

        // If OTP is not null, the email is not verified yet
        if ($user->otp !== null) {
            session(['user_email' => $request->user_email]); // Store the email in session for OTP verification
            return redirect()->route('registration-enter-otp')->with('warning', 'Your email is not verified. Please enter the OTP sent to your email.');
        }

        // Store the email in session for later use
        session(['user_email' => $request->user_email]);

        // Generate a new OTP for password reset
        $otp = mt_rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_created_at = Carbon::now(); // Set the OTP creation time
        $user->save();

        // Send the OTP via email
        $mail = new PHPMailer(true);
        try {
            // Mail server settings
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username = getenv('MAIL_USERNAME');
            $mail->Password = getenv('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = getenv('SMTP_PORT');

            // Set the email recipients
            $mail->setFrom('arlonielockon@gmail.com', 'Mailer');
            $mail->addAddress($request->user_email);

            // Set the email content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body    = 'Your password reset OTP is: ' . $otp . ' (it is only valid for 1 minute)';

            // Send the email
            $mail->send();

            // Redirect to OTP input page after sending the email
            return redirect(route('forgot-passwordP2'))->with('success', 'OTP has been sent to your email.');

        } catch (Exception $e) {
            // Log the error or handle it appropriately
            return redirect()->back()->with('error', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }

    public function forgot_passwordP2(){
        // if(Auth::check()){
        //     return redirect(route('home'));
        // }
        return view(view:'forgot-passwordP2');
    }
    public function forgot_passwordP2Post(Request $request){
        // Validate the input OTP
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        // Retrieve the user by the OTP
        $user = User::where('otp', $request->otp)->first();

        // Check if the user exists
        if (!$user) {
            return redirect()->route('forgot-passwordP2')->with('error', 'OTP incorrect!');
        }

        // Check if the OTP has expired (1 minute)
        $otpCreatedAt = Carbon::parse($user->otp_created_at);
        if ($otpCreatedAt->diffInMinutes(Carbon::now()) > 1) {
            return redirect()->route('forgot-passwordP2')->with('error', 'OTP has expired. Please request a new one.');
        }

        // OTP is valid, clear the OTP and move to password reset
        $user->otp = null;
        $user->otp_created_at = null;  // Clear the timestamp
        $user->save();

        // Redirect to the password reset page
        return redirect()->route('forgot-passwordP3')->with('success', 'OTP verified. You can now reset your password.');
    }


    public function forgot_passwordP3(){
        if(Auth::check()){
            return redirect(route('home'));
        }
        return view(view:'forgot-passwordP3');
    }
    public function forgot_passwordP3Post(Request $request){
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ], ['password_confirmation.same' => 'Password does not match.']);

        // Retrieve the user based on the email stored in the session
        $user_email = session('user_email');
        $user = User::where('user_email', $user_email)->first();

        if (!$user) {
            return redirect()->route('forgot-passwordP1')->with('error', 'Invalid session or user not found.');
        }

        // Update the user's password
        $user->password = bcrypt($request->password);
        $user->save();

        // Clear session email
        session()->forget('user_email');
        return redirect()->route('login')->with('success', 'Password has been successfully reset. You can now log in.');
    }

    public function requestOTP_verifier() {
        // Set the default timezone to Asia/Manila
        date_default_timezone_set('Asia/Manila');

        // Get the email from the session
        $user_email = session('user_email');

        // Find the user by email
        $user = User::where('user_email', $user_email)->first();

        if (!$user) {
            return redirect()->route('registration-enter-otp')->with('error', 'User not found.');
        }

        // Check if the last OTP was sent less than 1 minute ago
        $now = Carbon::now();
        $otpCreatedAt = $user->otp_created_at;

        // // Ensure `otp_created_at` is not null and check if the difference is less than 1 minute
        // if ($otpCreatedAt && $now->diffInMinutes($otpCreatedAt) < 1) {
        //     return redirect()->route('registration-enter-otp')->with('error', 'Please wait 1 minute before requesting a new OTP.');
        // }

        // Generate a new OTP
        $otp = mt_rand(100000, 999999);

        // Update OTP and otp_created_at
        $user->otp = $otp;
        $user->otp_created_at = Carbon::now(); // Set current timestamp
        $user->save();

        // Send the new OTP via email
        $mail = new PHPMailer(true);
        try {
            // Mail server settings
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username = getenv('MAIL_USERNAME');
            $mail->Password = getenv('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = getenv('SMTP_PORT');

            // Recipients
            $mail->setFrom('arlonielockon@gmail.com', 'Mailer');
            $mail->addAddress($user_email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verifier OTP';
            $mail->Body = 'Your new OTP is: ' . $otp . ' (it is only valid for 1 minute)';

            $mail->send();
        } catch (Exception $e) {
            return redirect()->route('registration-enter-otp')->with('error', 'Failed to send OTP. Please try again.');
        }

        return redirect()->route('registration-enter-otp')->with('success', 'A new OTP has been sent to your email.');
    }

    public function requestOTP_reset() {
        // Get the email from the session
        $user_email = session('user_email');

        // if (!$email) {
        //     return redirect()->route('forgot-passwordP1')->with('error', 'Session expired. Please start the password reset process again.');
        // }

        // Find the user by email
        $user = User::where('user_email', $user_email)->first();
        if (!$user) {
            return redirect()->route('forgot-passwordP1')->with('error', 'User not found.');
        }

        // Check if the last OTP was sent less than 1 minute ago
        $now = Carbon::now();
        $otpCreatedAt = $user->otp_created_at;

        // if ($otpCreatedAt && $now->diffInMinutes($otpCreatedAt) < 1) {
        //     return redirect()->route('forgot-passwordP2')->with('error', 'Please wait 1 minute before requesting a new OTP.');
        // }

        // Generate a new OTP
        $otp = mt_rand(100000, 999999);

        // Update OTP and otp_created_at
        $user->otp = $otp;
        $user->otp_created_at = Carbon::now();
        $user->save();

        // Send the new OTP via email
        $mail = new PHPMailer(true);
        try {
            // Mail server settings
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username = getenv('MAIL_USERNAME');
            $mail->Password = getenv('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = getenv('SMTP_PORT');

            // Recipients
            $mail->setFrom('arlonielockon@gmail.com', 'Mailer');
            $mail->addAddress($user_email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = 'Your OTP for password reset is: ' . $otp . ' (it is only valid for 1 minute)';

            $mail->send();
        } catch (Exception $e) {
            return redirect()->route('forgot-passwordP2')->with('error', 'Failed to send OTP. Please try again.');
        }

        return redirect()->route('forgot-passwordP2')->with('success', 'A new OTP has been sent to your email.');
    }


    // public function adminDashboard(){
    //     if(Auth::check()){
    //         return redirect(route('cclogin'));
    //     }
    //     return view('welcome-admin');
    // }
    // public function adminDashboard() {
    //     if (!Auth::check()) {  // Check if the user is not authenticated
    //         return redirect(route('cclogin'));  // Redirect to login if not authenticated
    //     }
    //     return view('welcome-admin');  // Show the admin dashboard if authenticated
    // }

    // public function logout(Request $request) {
    //     Auth::logout(); // Log out the user

    //     // Invalidate the session and regenerate the CSRF token
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     // Redirect to the cclogin page
    //     return redirect()->route('cclogin');
    // }

    public function logout(Request $request) {
        // Determine which guard to use
        $guard = Auth::guard('admin')->check() ? 'admin' : 'web';

        Auth::guard($guard)->logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the cclogin page
        return redirect()->route('login');
    }
}
