<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $resetLink = url('/reset-password/'.$token.'?email='.$request->email);

        Mail::send('emails.reset-password', ['resetLink'=>$resetLink], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success','Reset link sent to your email');
    }

}
