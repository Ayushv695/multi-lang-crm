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
                return $this->errorResponse('User not found.');
            }

        } catch (TokenExpiredException $e) {
            return $this->errorResponse('Token has expired.');

        } catch (TokenInvalidException $e) {
            return $this->errorResponse('Invalid token.');

        } catch (JWTException $e) {
            return $this->errorResponse('Token is missing.');
        }

        return $next($request);
    }

    private function errorResponse(string $message)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 401);
    }
}
