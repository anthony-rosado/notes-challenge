<?php

namespace Tests\Feature;

use App\Entities\Group;
use App\Entities\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GroupTest extends TestCase
{
    private $endpoint = '/api/groups';

    public function testGroupListFailed()
    {
        $response = $this->getJson($this->endpoint);

        $response->assertUnauthorized();
    }

    public function testGroupListSuccess()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->getJson($this->endpoint);

        $response->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function testJoinGroupFailed()
    {
        $group = factory(Group::class)->create();

        $response = $this->postJson("{$this->endpoint}/{$group->id}/join");

        $response->assertUnauthorized();
    }

    public function testJoinGroupSuccess()
    {
        $group = factory(Group::class)->create();
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson("{$this->endpoint}/{$group->id}/join");

        $response->assertOk()
            ->assertJsonStructure(['data', 'message']);
    }
}
