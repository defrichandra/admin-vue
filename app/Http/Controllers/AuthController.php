<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AuthController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth:api', ['except' => 'login', 'logout']);
    // }

    public function index()
    {
        return view('restricted-screen');
    }

    public function register(Request $request)
    {
        return User::create([
            'email' => $request->input(key: 'email'),
            'password' => Hash::make($request->input(key: 'password')),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // if (!Auth::attempt($credentials)) {
        //     return response()->json(['message' => 'Invalid credentials!'], 401);
        // }

        if (Auth::guard('web')->attempt($credentials)) {
            // requests good
            $user = Auth::guard('web')->user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie(name: 'jwt', value: $token, minutes: 60 * 24); //1 day

            return response()->json(['message' => 'success', 'token' => $token])->withCookie($cookie);
        } else {
            // invalid credentials, act accordingly
            return response()->json(['message' => 'Invalid credentials!'], 401);
        }   
        // return response()->json(['message' => 'success'])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response()->json(['message' => 'success'])->withCookie($cookie);
    }

    // protected function guard() {
    //     return Auth::guard();
    // }
}