<?php

namespace Tests\Feature;

use App\Entities\Group;
use App\Entities\Note;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CreateNoteTest extends TestCase
{
    use WithFaker;

    private $endpoint = '/api/notes';

    private $headers = [
        'Accept' => 'application/json',
    ];

    public function testCreateNoteWithoutLogin()
    {
        $response = $this->post($this->endpoint, [], $this->headers);

        $response->assertUnauthorized();
    }

    public function testCreateNoteWithoutBelongsToTheGroup()
    {
        Passport::actingAs(factory(User::class)->create());

        $randomGroupId = Group::inRandomOrder()->first()->id;

        $note = [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'group_id' => $randomGroupId,
            'attachments' => [
                UploadedFile::fake()->image('testX'),
                UploadedFile::fake()->image('testZ'),
                UploadedFile::fake()->image('testW'),
            ],
        ];

        $response = $this->post($this->endpoint, $note, $this->headers);

        $this->assertAuthenticated();
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['errors', 'message']);
    }

    public function testCreateNoteWithoutBody()
    {
        /**@var User $user*/
        $user = factory(User::class)->create();
        $group = Group::inRandomOrder()->first();
        $user->groups()->attach($group->id);

        Passport::actingAs($user);

        $response = $this->post($this->endpoint, [], $this->headers);

        $this->assertAuthenticated();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors']);
    }

    public function testCreateNoteSuccess()
    {
        /**@var User $user*/
        $user = factory(User::class)->create();
        $group = Group::inRandomOrder()->first();
        $user->groups()->attach($group->id);

        Passport::actingAs($user);
        $note = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'group_id' => $group->id,
            'attachments' => [
                UploadedFile::fake()->image('testX.jpg'),
                UploadedFile::fake()->image('testZ.jpg'),
                UploadedFile::fake()->image('testW.jpg'),
            ],
        ];

        $response = $this->post($this->endpoint, $note, $this->headers);

        $this->assertAuthenticated();
        $response->assertCreated()
            ->assertJsonStructure(['data', 'message']);
    }
}
