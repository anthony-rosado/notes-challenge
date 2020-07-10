<?php

use App\Entities\Note;
use App\Entities\User;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Note::class, 30)->make()->each(function (Note $note) {
            /**@var User $user*/
            $user = User::whereHas('groups')->inRandomOrder()->first();
            $randomUserGroup = $user->groups()->inRandomOrder()->first();

            $note->user()->associate($user);
            $note->group()->associate($randomUserGroup);
            $note->save();
        });
    }
}
