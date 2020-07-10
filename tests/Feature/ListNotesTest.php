<?php

namespace Tests\Feature;

use App\Entities\Group;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ListNotesTest extends TestCase
{
    private $endpoint = '/api/notes';

    private $headers = [
        'Accept' => 'application/json',
    ];

    public function testNoteListWithoutLogin()
    {
        $response = $this->get($this->endpoint, $this->headers);

        $response->assertUnauthorized();
    }

    public function testNoteListWithoutGroupId()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->get($this->endpoint, $this->headers);

        $this->assertAuthenticated();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testNoteListWithoutBelongsToTheGroup()
    {
        Passport::actingAs(factory(User::class)->create());

        $randomGroupId = Group::inRandomOrder()->first()->id;
        $response = $this->get("{$this->endpoint}?group_id={$randomGroupId}", $this->headers);

        $this->assertAuthenticated();
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testNoteListSuccess()
    {
        /**@var User $user*/
        $user = factory(User::class)->create();
        $group = Group::inRandomOrder()->first();
        $user->groups()->attach($group->id);

        Passport::actingAs($user);
        $response = $this->get("{$this->endpoint}?group_id={$group->id}", $this->headers);

        $this->assertAuthenticated();
        $response->assertOk();
    }
}
