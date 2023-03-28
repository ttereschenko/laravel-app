<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DeleteRequest;
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

    public function index(): JsonResponse
    {
        $emails = $this->userService->getEmailsList();

        return response()->json(['users' => $emails], Response::HTTP_OK);
    }

    public function show(ShowRequest $request, User $user): JsonResponse
    {
        return response()->json(new UserResource($user), Response::HTTP_OK);
    }

    public function delete(DeleteRequest $request, User $user): JsonResponse
    {
        $this->userService->delete($user);

        return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
    }
}
