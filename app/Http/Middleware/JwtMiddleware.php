<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return errorJWTTokenResponse('User not found.','USER_NOT_FOUND');
            }

        } catch (TokenExpiredException $e) {
            return errorJWTTokenResponse('Token has expired.','TOKEN_EXPIRED');

        } catch (TokenInvalidException $e) {
            return errorJWTTokenResponse('Invalid token.','TOKEN_INVALID');

        } catch (JWTException $e) {
            return errorJWTTokenResponse('Token is missing.','TOKEN_MISSING');
        }

        return $next($request);
    }

    // private function errorResponse(string $message, string $code)
    // {
    //     return response()->json([
    //         'success' => false,
    //         'code' => $code,
    //         'message' => $message,
    //     ], 401);
    // }
}
