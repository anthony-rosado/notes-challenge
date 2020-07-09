<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'filename', 'note_id',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
