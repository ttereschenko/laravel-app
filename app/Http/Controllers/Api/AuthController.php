<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): Response
    {
        $data = $request->validated();
        $user = new User($data);
        $user->save();

        $token = $user->createToken('LaravelPassportAuth')->accessToken;
        $response = ['token' => $token];

        return response($response, 201);
    }
}
