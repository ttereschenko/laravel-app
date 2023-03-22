<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * @throws BindingResolutionException
     */
    public function test_store_method(): void
    {
        $userService = app()->make(UserService::class);

        $data = [
            'email' => $this->faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $createdUser = $userService->store($data);

        $this->assertInstanceOf(User::class, $createdUser);
    }
}
