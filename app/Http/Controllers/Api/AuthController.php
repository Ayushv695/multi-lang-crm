<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function register(RegistrationRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['role'] = User::MANAGER;

        $user = $this->userRepository->create($validatedData);

        return successResponse(
            data: [
                'user' => new UserResource($user),
            ],
            message: 'User registered successfully.',
            status: 201
        );
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $token = auth()->attempt($credentials);
        
        if (!$token) {
            return errorResponse(
                message: 'Invalid email or password.',
                status: 401
            );
        }

        return successResponse(
            data: [
                'user' => new UserResource(auth()->user()),
                'token' => $token,
                'token_type' => 'bearer',
            ],
            message: 'Login successful.'
        );
    }

    public function profile()
    {
        return successResponse(
            data: [
                'user' => new UserResource(auth()->user()),
            ]
        );
    }

    public function logout()
    {
        auth()->logout();
        return successResponse(
            message: 'Successfully logged out.'
        );
    }

    public function refreshToken()
    {
        try {

            $token = JWTAuth::parseToken()->refresh();

            return successResponse(
                data: [
                    'token' => $token,
                    'token_type' => 'bearer',
                ],
                message: 'Token refreshed successfully.'
            );

        } catch (TokenInvalidException $e) {

            return errorResponse(
                message: 'Invalid token.',
                status: 401
            );

        } catch (TokenExpiredException $e) {

            return errorResponse(
                message: 'Token can no longer be refreshed.',
                status: 401
            );

        } catch (JWTException $e) {

            return errorResponse(
                message: 'Token is missing.',
                status: 401
            );
        }
    }
}
