<?php

namespace App\Observers;

use App\Entities\Group;
use App\Entities\Note;
use App\Notifications\NoteCreated;
use Illuminate\Support\Facades\Notification;

class NoteObserver
{
    /**
     * Handle the note "created" event.
     *
     * @param Note $note
     * @return void
     */
    public function created(Note $note)
    {
        /**@var Group $group*/
        $group = $note->group()->first();
        $users = $group->members()->get();

        Notification::send($users, new NoteCreated($note));
    }

    /**
     * Handle the note "updated" event.
     *
     * @param Note $note
     * @return void
     */
    public function updated(Note $note)
    {
        //
    }

    /**
     * Handle the note "deleted" event.
     *
     * @param Note $note
     * @return void
     */
    public function deleted(Note $note)
    {
        //
    }

    /**
     * Handle the note "restored" event.
     *
     * @param Note $note
     * @return void
     */
    public function restored(Note $note)
    {
        //
    }

    /**
     * Handle the note "force deleted" event.
     *
     * @param Note $note
     * @return void
     */
    public function forceDeleted(Note $note)
    {
        //
    }
}
