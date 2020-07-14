<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

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
            $status = 200;
            $user = Auth::user();
            $response = [
                'check' => true,
                'user' => Auth::user(),
                'name' => Auth::user()->name,
                'token' => $user->createToken('Video4You')->accessToken,
            ];
        }
        return response()->json($response, $status);
    }
    // public function getVideo()
    // {
    //     dd(Auth::user());
    //     $list = Video::get();
    //     return $list;
    // }
}
