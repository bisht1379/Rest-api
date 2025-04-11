<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        return response()->json(['message'=>'user create successfully']);


    }

    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if(!$user || ! hash::check($request->password,$user->password))
        {
            throw ValidationException::withMessages([
                'email'=>['the provided credentionals are incorrect']
            ]);

        }
            $token = $user->createtoken('auth_token')->plainTextToken;

            return response()->json([

                'access_token'=>$token,
                'token_type'=>'Bearer',
            ]);


    }

public function logout( Request $request)
{

    $request->user()->$token->delete();
    return response()->json(['message'=>'logged out']);
}



}
