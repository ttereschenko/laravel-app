<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function update(User $user, UpdateRequest $request): JsonResponse
    {
        if ($user->can('update', $user)) {
            $this->userService->update($user, $request->validated());

            return response()->json(['message' => 'Updated successfully'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Access denied'], Response::HTTP_FORBIDDEN);
    }
}
