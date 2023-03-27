<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_user_info()
    {
        $user = Passport::actingAs(
            User::factory()->create(),
        );
        $email = 'test@test';
        $password = '12345678';

        $this->putJson(route('users.update', ['user' => $user->id]), [
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ])->assertOk();
    }

    public function test_update_user_info_if()
    {
        $users = User::factory(2)->create();
        Passport::actingAs($users[0]);

        $email = 'test@test';
        $password = '12345678';

        $this->putJson(route('users.update', ['user' => $users[1]->id]), [
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ])->assertForbidden();
    }
}
