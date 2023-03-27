<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {}

    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $this->userService->update($user, $request->validated());

        return response()->json(['message' => 'Updated successfully'], Response::HTTP_OK);
    }

    public function list(): JsonResponse
    {
        $emails = $this->userService->list();

        return response()->json(['users' => $emails], Response::HTTP_OK);
    }

    public function show(ShowRequest $request, User $user): UserResource
    {
        return new UserResource($user);
    }
}