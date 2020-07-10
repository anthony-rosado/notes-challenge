<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    private $endpoint = '/api/auth/register';

    public function testRegisterFailed()
    {
        $response = $this->postJson($this->endpoint, []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors', 'message']);
    }

    public function testRegisterSuccess()
    {
        $user = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->email,
            'password' => $this->faker->password,
        ];

        $response = $this->postJson($this->endpoint, $user);

        $response->assertCreated()
            ->assertJsonStructure(['data', 'message']);
    }
}
