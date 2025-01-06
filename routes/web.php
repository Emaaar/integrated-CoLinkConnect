<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ContractingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TrackerController;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\NeedsAssessmentController;
use App\Http\Controllers\FormController;


Route::get('/form/needs-assessment', [NeedsAssessmentController::class, 'showForm']);
Route::post('/form/needs-assessment/submit', [NeedsAssessmentController::class, 'submitForm']);
Route::get('/form/{id}', [FormController::class, 'show'])->name('form.show');

// MARK: Admin-/tracker
Route::prefix('tracker')->group(function () {
    
});
Route::get('/tracker', [TrackerController::class, 'tracker'])->name('tracker');


// MARK: DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
// MARK: HOME
Route::get('/', function (): View {
    return view('home');
})->name('home');

// Admin Dashboard
Route::get('/admin-dashboard', function () { 
    return view('dashboard');
})->name('admin-dash');
Route::get('/team', function () {
    return view('team');
});

Route::get('/impact', function () {
    return view('impact');
});
Route::get('/intervention', function () {
    return view('intervention');
});
Route::get('/blog-details', function () {
    return view('blog-details');
});

Route::get('/user-profile', function () {
    return view('user-profile');
});

// MARK: AUTHENTICATION
Route::get('/colink-login', [AuthManager::class, 'login'])->name('login');
Route::post('/colink-login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');

Route::get('/data', function () { return view('data');})->name('data');

// OTP Routes
Route::get('/registration-enter-otp', [AuthManager::class, 'registration_enterOTP'])->name('registration-enter-otp');
Route::post('/registration-enter-otp', [AuthManager::class, 'registration_enterOTP_Post'])->name('registration-enter-otp.post');

Route::get('/forgot-password-P1', [AuthManager::class, 'forgot_passwordP1'])->name('forgot-passwordP1');
Route::post('/forgot-password-P1', [AuthManager::class, 'forgot_passwordP1Post'])->name('forgot-passwordP1.post');

Route::get('/forgot-password-P2', [AuthManager::class, 'forgot_passwordP2'])->name('forgot-passwordP2');
Route::post('/forgot-password-P2', [AuthManager::class, 'forgot_passwordP2Post'])->name('forgot-passwordP2.post');

Route::get('/forgot-password-P3', [AuthManager::class, 'forgot_passwordP3'])->name('forgot-passwordP3');
Route::post('/forgot-password-P3', [AuthManager::class, 'forgot_passwordP3Post'])->name('forgot-passwordP3.post');

Route::get('/request-OTP-verifier', [AuthManager::class, 'requestOTP_verifier'])->name('requestOTP-verifier');
Route::get('/request-OTP-reset', [AuthManager::class, 'requestOTP_reset'])->name('requestOTP-reset');

Route::post('/logout', [AuthManager::class, 'logout'])->name('logout');

// MARK: USER ROUTES (Requires Authentication)
Route::middleware('auth:web')->group(function () {

    // Donation Routes
    Route::get('/donation', [DonationController::class, 'donation'])->name('donation');
    Route::get('/donation-gcash', [DonationController::class, 'donationQR1'])->name('donation-gcash');
    Route::get('/donation-paymaya', [DonationController::class, 'donationQR2'])->name('donation-paymaya');
    Route::post('/donation', [DonationController::class, 'donationPost'])->name('donation.post');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    // Progress Tracker Route
    Route::get('/progress-tracker', function () {return view('progress');})->name('progress');
});

// Chat Routes
Route::middleware('auth:web')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/delete', [ChatController::class, 'deleteConversation'])->name('chat.delete');
});

// MARK: Contact Us
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// MARK: ADMIN ROUTES (Requires Admin Authentication)
Route::middleware(['auth:admin'])->group(function () {

    // Admin Chat Routes
    Route::get('/admin/chat/history/{userEmail}', [ChatController::class, 'getChatHistory'])->name('admin.chat.history');
    Route::get('/admin/chat', [ChatController::class, 'adminChat'])->name('admin.chat');
    Route::post('/admin/chat/send', [ChatController::class, 'adminSendMessage'])->name('admin.chat.send');

    // Contracting Routes
    Route::get('/contracting', [ContractingController::class, 'contracting'])->name('contracting');
    Route::post('/contracting', [ContractingController::class, 'contractingPost'])->name('contracting.post');
    Route::post('/search-client', [ContractingController::class, 'searchClient'])->name('search.client');

    // Record Routes
    Route::get('/records', [RecordController::class, 'records'])->name('records');

    // Blog Routes
    Route::get('/blog', [BlogController::class, 'upload'])->name('blog');
    Route::post('/blog', [BlogController::class, 'uploadStore'])->name('blog.store');
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
});
