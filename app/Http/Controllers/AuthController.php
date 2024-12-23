<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\JWTService;

class AuthController extends Controller
{
    protected $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $this->jwtService->createToken(['uid' => $user->id]);

            return response()->json([
                'token' => $token->toString(),
                'user' => $user,
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
