<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function test_register(): void
    {
        $data = [
            'email' => $this->faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->postJson(route('register'), $data)->assertStatus(Response::HTTP_CREATED);
    }
}
