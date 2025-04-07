<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Mail\Message;
use Illuminate\Support\str;
use Carbon\Carbon;
class PasswordResetController extends Controller
{
    public function send_password_reset(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        $email = $request->email;
        $user_email = User::where('email',$email)->first();
        if(!$user_email){
            return response([
                'message' => 'Email Id does Not exist',
                'status' => 'Failed'
            ],404);
        }
        $token = str::random(60);
        PasswordReset::create([
            'email' => $email,
            'token' => $token,
            'create_at' => Carbon::now(),
            'update_at' => Carbon::now(),
        ]);
        Mail::send('reset',['token'=>$token], function(Message $message)use($email){
            $message->subject('reset your password');
            $message->to($email);
        });

        return response([
            'message' => 'Password has been Send on your Mail Id',
            'status' => 'success'
        ],200);

    }

    public function reset(Request $request, $token){
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        $passwordreset = PasswordReset::where('token', $token)->first();
        if(!$passwordreset){
            return response([
                'message' => 'Token is expired or Not found',
                'status' => 'failed'
            ],404);
        }
        $user = User::where('email',$passwordreset->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();
        PasswordReset::where('email',$user->email)->first();
        return response([
                'message' => 'Password Reset Success',
                'status' => 'success'
            ],200);
    }
}
