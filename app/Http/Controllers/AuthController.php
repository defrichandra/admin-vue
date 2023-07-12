<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

class AuthController extends Controller
{
    private $jwt;
    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
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

        try {
            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = auth()->user();

        $tokenDetails = [
            'token' => $token,
            'expires_in' => $this->jwt->factory()->getTTL() * 60 * 24,
            // Expiration time in seconds
            'issued_at' => $this->jwt->factory()->getPayload($token)->get('iat'),
        ];

        $cookie = cookie(name: 'jwt', value: $token, minutes: 60 * 24);

        return response()->json([
            'message' => 'success',
            'tokenDetails' => $tokenDetails,
            'user' => $user
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            $user = Auth::user();
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }

    public function logout(Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            Auth::logout();

            // Clear the user session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }
}