<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);

    }

    public function register(RegisterRequest $request)
    {
        // dd($request);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response([
            'user' => $user,

        ]);

    }
    public function login(LoginRequest $request)
    {
        $name = $request->name;
        $password = $request->password;
        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            return response()->json([
                'check' => Auth::check(),
                'name' => Auth::user()->name,
            ]);
        } else {
            return response([
                'mess' => 'loi',
            ]);
        }
    }
   public function isLogin(){
       $s=Auth::check();
       return $s;
    //    if(Auth::check()){
    //        return response([
    //            'check'=>true
    //        ]);
    //    }else{
    //        return response([
    //         'check'=>false
    //     ]);
    //    }
    // return response()->json(['check'])
   }
}