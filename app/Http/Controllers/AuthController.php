<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWT;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    private $jwt;
    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_confirmation' => $request->password_confirmation,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'message' => 'success',
            'user' => $user
        ], 200);
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
        $expirationTime = Carbon::parse(Auth::guard('web')->payload()->get('exp'))->setTimezone('Asia/Jakarta')->toDateTimeString();

        $tokenDetails = [
            'token' => $token,
            'expires_in' => $expirationTime,
            'issued_at' => Carbon::now()->format('Y-m-d H:i:s'),
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
        if ($request->bearerToken()) {
            try {
                $users = User::all(); // Retrieve all users from the database
                return response()->json(['users' => $users]);
            } catch (TokenExpiredException $e) {
                // Token has expired, return a response indicating unauthorized access
                return response()->json(['error' => 'Token expired'], 401);
            } catch (TokenInvalidException $e) {
                // Token is invalid, return a response indicating unauthorized access
                return response()->json(['error' => 'Invalid token'], 401);
            } catch (JWTException $e) {
                // Failed to decode the token, return a response indicating unauthorized access
                return response()->json(['error' => 'Failed to decode token'], 401);
            }
        }

        // Token not provided or not valid, return a response indicating unauthorized access
        return response()->json(['error' => 'Unauthorized'], 401);
    }


    public function profile(Request $request)
    {
        if ($request->bearerToken()) {
            try {
                $user = Auth::guard('web')->user();

                // Read Token expiration time
                Auth::guard('web')->payload()->get('exp');

                if ($user) {
                    // User is authenticated
                    return response()->json(['user' => $user]);
                }
            } catch (TokenExpiredException $e) {
                // Token has expired, return a response indicating unauthorized access
                return response()->json(['error' => 'Token expired'], 401);
            } catch (TokenInvalidException $e) {
                // Token is invalid, return a response indicating unauthorized access
                return response()->json(['error' => 'Invalid token'], 401);
            } catch (JWTException $e) {
                // Failed to decode the token, return a response indicating unauthorized access
                return response()->json(['error' => 'Failed to decode token'], 401);
            }
        }

        // Token not provided or not valid, return a response indicating unauthorized access
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        if ($request->bearerToken()) {
            try {
                Auth::user();

                // Read Token expiration time
                Auth::guard('web')->payload()->get('exp');
            } catch (TokenExpiredException $e) {
                // Token has expired, perform necessary actions
                // For example, log the user out and return an error response
                // Auth::logout();
                // $request->session()->invalidate();
                // $request->session()->regenerateToken();

                return response()->json(['error' => 'Token expired. Please log in again.'], 401);
            }

            // Token is valid, proceed with the logout process
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['error' => 'Authorization not provided.'], 401);
        }
    }
}