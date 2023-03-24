<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_password_reset_notification()
    {
        $user = User::factory()->create();

        $this->postJson(route('password.forgot'), [
            'email' => $user->email,
        ])->assertOk();
    }

    public function test_if_email_does_not_exist()
    {
        User::factory()->create();
        $email = 'test@test';

        $this->postJson(route('password.forgot'), [
            'email' => $email,
        ])->assertUnprocessable();
    }

    public function test_password_reset()
    {
        $user = User::factory()->create();
        $password = '12345678';
        $token = Password::createToken($user);

        $this->postJson(route('password.reset'), [
            'token' => $token,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ])->assertOk();
    }

    public function test_if_password_is_invalid()
    {
        $user = User::factory()->create();
        $password = '123456';
        $token = Password::createToken($user);

        $this->postJson(route('password.reset'), [
            'token' => $token,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ])->assertUnprocessable();
    }
}
