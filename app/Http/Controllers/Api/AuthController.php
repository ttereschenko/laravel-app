<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->store($request->validated());
        $token = $user->createToken('LaravelPassportAuth')->accessToken;

        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userService->login($request->validated());

        if ($user) {
            $token = $user->createToken('LaravelPassportAuth')->accessToken;

            return response()->json(['token' => $token], Response::HTTP_OK);
        }

        return response()->json(
            ['message' => 'The provided credentials are incorrect', 'errors' => 'Unauthorised'],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
