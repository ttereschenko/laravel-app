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

    public function test_update_other_users_info()
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

    public function test_list_users_emails()
    {
        Passport::actingAs(
            User::factory()->create(),
        );

        $this->getJson(route('users.list'))->assertOk();
    }

    public function test_list_users_emails_if_user_unregistered()
    {
        User::factory()->create();

        $this->getJson(route('users.list'))->assertUnauthorized();
    }

    public function test_show_user_info()
    {
        $user = Passport::actingAs(
            User::factory()->create(),
        );

        $this->getJson(route('user.show', ['user' => $user->id]))->assertOk();
    }

    public function test_show_other_users_info()
    {
        $users = User::factory(2)->create();
        Passport::actingAs($users[0]);

        $this->getJson(route('user.show', ['user' => $users[1]]))->assertForbidden();
    }
}
