<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Throwable;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new patient through the API.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->register(
                $request->validated()
            );

            $token = $user
                ->createToken('postman-token')
                ->plainTextToken;

            return response()->json([
                'message' => 'Registration successful.',
                'user' => new UserResource($user),
                'token' => $token,
                'token_type' => 'Bearer',
            ], 201);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Registration failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Authenticate a user through the API.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->authenticate(
                $request->validated()
            );

            if (!$user) {
                return response()->json([
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            $token = $user
                ->createToken('postman-token')
                ->plainTextToken;

            return response()->json([
                'message' => 'Login successful.',
                'user' => new UserResource($user),
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Login failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Return the authenticated API user.
     */
    public function me(): JsonResponse
    {
        return response()->json([
            'message' => 'Authenticated user retrieved successfully.',
            'user' => new UserResource(request()->user()),
        ]);
    }

    /**
     * Log out the authenticated API user.
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()
                ->currentAccessToken()
                ->delete();

            return response()->json([
                'message' => 'Logout successful.',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Logout failed. Please try again.',
            ], 500);
        }
    }
}
