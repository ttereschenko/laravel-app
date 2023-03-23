<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_register(): void
    {
        $data = [
            'email' => $this->faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->postJson(route('register'), $data)->assertCreated();
    }

    public function test_user_login(): void
    {
        $user = User::factory()->create();

        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertOk();
    }

    public function test_if_user_password_is_not_correct(): void
    {
        $user = User::factory()->create();

        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'qwerty',
        ])->assertUnauthorized();
    }

    public function test_if_user_email_is_not_correct(): void
    {
        $user = User::factory()->create();

        $this->postJson(route('login'), [
            'email' => 'test@test',
            'password' => $user->password,
        ])->assertUnauthorized();
    }
}
