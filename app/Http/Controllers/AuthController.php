<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Show Login Page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login Function
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email or Password incorrect');
        }

        // Email verification check
        if (!$user->email_verified_at) {
            return back()->with('error', 'Please verify your email first.');
        }

        // Account active check
        if ($user->is_active != 1) {
            return back()->with('error', 'Account not active.');
        }

        // Attempt login
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('welcome');
        }

        return back()->with('error', 'Email or Password incorrect');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Show Register Page
    public function showRegister()
    {
        return view('auth.register');
    }

    // Register Function
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'address' => 'required'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'is_active' => 0,
            'email_verified_at' => null
        ]);

        // Generate token
        $token = Str::random(64);

        // Save token in table
        DB::table('email_verifications')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send verification email
        Mail::send('emails.verify', ['token' => $token], function ($message) use ($user) {
    $message->to($user->email);
    $message->subject('Email Verification');
});

        return redirect()->route('login')
            ->with('success', 'Verification email sent. Please check your email.');
    }

    // Email Verification Function
    public function verifyEmail($token)
    {
        // Check token in email_verifications table
        $record = DB::table('email_verifications')
                    ->where('token', $token)
                    ->first();

        if (!$record) {
            return redirect()->route('login')
                ->with('error', 'Invalid verification token');
        }

        // Find user by email
        $user = User::where('email', $record->email)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        // Update user verification
        $user->email_verified_at = now();
        $user->is_active = 1;
        $user->save();

        // Delete token
        DB::table('email_verifications')
            ->where('email', $user->email)
            ->delete();

        return redirect()->route('login')
            ->with('success', 'Email verified successfully. You can now login.');
    }
}
