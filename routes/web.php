<?php
 use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;


// use Illuminate\Support\Facades\Mail;


// Default route
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Email verify
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

// Forgot & reset password
Route::get('/forgot-password', [ForgotPasswordController::class,'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class,'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class,'resetPassword'])->name('password.update');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/welcome', [HomeController::class, 'index'])->name('welcome');
});

// Profile
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
