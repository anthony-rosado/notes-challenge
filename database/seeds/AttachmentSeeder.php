<?php

use App\Entities\Attachment;
use App\Entities\Note;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Note::all()->each(function (Note $note) {
            $note->attachments()->saveMany(
                factory(Attachment::class, 2)->make()
            );
        });
    }
}
