<?php

namespace Tests\Feature;

use App\Entities\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;

    private $endpoint = '/api/auth/login';

    public function testLoginWithoutCredentials()
    {
        $response = $this->postJson($this->endpoint, []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors', 'message']);
    }

    public function testLoginWithWrongCredentials()
    {
        $response = $this->postJson($this->endpoint, [
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors', 'message']);
    }

    public function testLoginSuccess()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson($this->endpoint, [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['data', 'message']);
    }
}
