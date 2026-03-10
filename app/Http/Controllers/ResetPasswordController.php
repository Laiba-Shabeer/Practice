<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{

    public function showResetForm($token)
    {
        return view('auth.reset',[
            'token'=>$token
        ]);
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:6|confirmed'
        ]);

        $record = DB::table('password_resets')
        ->where('email',$request->email)
        ->where('token',$request->token)
        ->first();

        if(!$record){
            return back()->with('error','Invalid token');
        }

        // link expiry check (60 minutes)
        if(Carbon::parse($record->created_at)->addMinutes(60)->isPast()){
            return back()->with('error','Reset link expired');
        }

        // password update
        User::where('email',$request->email)
            ->update([
                'password'=>Hash::make($request->password)
            ]);

        // delete reset record
        DB::table('password_resets')
            ->where('email',$request->email)
            ->delete();

        return redirect()->route('login')
            ->with('success','Password reset successfully');
    }

}
