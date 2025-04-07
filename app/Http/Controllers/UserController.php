<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{   
    public function post_url(Request $request){
        return view('reset');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'tc' => 'required',
        ]);
        if(User::where('email',$request->email)->first()){
            return response([
                'message' => 'This Email Id Already Exist',
            ],200);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tc' => json_decode($request->tc)
        ]);
        $token = $user->createToken($request->email)->plainTextToken;

        return response([
            'token' => $token,
            'message' => 'Successfully created !!',
        ],201);
        
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            $token = $user->createToken($request->email)->plainTextToken;
            return response([
                'token' => $token,
                'message' => 'login success !!',
            ],200);
        }
        return response([
            'message' => 'Somthing went wrong'
        ],401);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
                'message' => 'logout success !!',
            ],200);
    }

    public function logged_user(){
        $logged = auth()->user();
        return response([
                'logged' => $logged,
                'message' => 'logout success !!',
            ],200);
    }

    public function change_pass(Request $request){
        $request->validate([
            'password' => 'required|confirmed'
        ]);
        $logged = auth()->user();
        $logged->password = Hash::make($request->password);
        $logged->save();
            return response([
                'message' => 'change success !!',
            ],200);
    }

    public function delete($id){
        $delete = User::find($id)->delete();
        return $delete;
    }
}
