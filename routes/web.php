<?php
 use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Mail;




Route::get('/welcome', [HomeController::class, 'index'])->name('welcome');
// show login page
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// save values
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// show register page show
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// register form submit
Route::post('/register', [AuthController::class, 'register']);

Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])
    ->name('verify.email');



// Route::get('/test-mail', function () {
//     Mail::raw('Testing Mailpit!', function ($message) {
//         $message->to('someone@example.com')
//                 ->subject('Mailpit Test');
//     });
//     return 'Mail sent!';
// });
