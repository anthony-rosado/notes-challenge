<?php

use App\Entities\Group;
use App\Entities\User;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randomUsers = User::inRandomOrder();

        factory(Group::class, 10)->create()->each(function (Group $group) use ($randomUsers) {
            $users = $randomUsers->take(8)->get();
            $group->members()->sync($users);
        });
    }
}
