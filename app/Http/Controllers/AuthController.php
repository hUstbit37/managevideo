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
       
        $status = 401;
        $response = ['error' => 'Unauthorised'];
        if (Auth::attempt($request->only(['name', 'password']))) {
            $status=200;
            $response=[
                'check'=>true,
                'user' => Auth::user(),
                'name' => Auth::user()->name,
                'token'=> Auth::user()->createToken('Video4You')->accessToken,
            ];
        } 
        return response()->json($response, $status);
   

        // $email = $request->email;
        // $password = $request->password;
        // if (Auth::attempt(['email' => $email, 'password' => $password])) {
        //     return response()->json([
        //         'check' => Auth::check(),
        //         'name' => Auth::user()->name,
                
        //     ]);
        // } else {
        //     return response([
        //         'mess' => 'loi',
        //     ]);
        // }
    }
    public function getVideo()
    {
        dd(Auth::user());
        $list=Video::get();
        return $list;
    }
}