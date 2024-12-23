<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\JWTService;
use Lcobucci\JWT\Token\Plain;

class JWTMiddleware
{
    protected $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle(Request $request, Closure $next)
    {
        // Retrieve the Bearer token from the request
        $tokenString = $request->bearerToken();

        if (!$tokenString) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        // Parse the token
        $parsedToken = $this->jwtService->parseToken($tokenString);

        if (!$parsedToken || !$this->jwtService->validateToken($parsedToken)) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Ensure the token is of type `Plain`
        if (! $parsedToken instanceof Plain) {
            return response()->json(['error' => 'Invalid token structure'], 401);
        }

        // Retrieve claims from the token
        $claims = $parsedToken->claims();

        if (!$claims->has('uid')) {
            return response()->json(['error' => 'UID not present in token'], 401);
        }

        // Attach the UID to the request for downstream usage
        $request->merge(['user_id' => $claims->get('uid')]);

        return $next($request);
    }
}
