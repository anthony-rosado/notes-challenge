<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $fillable = [
        'filename', 'note_id',
    ];

    public function getFilenameAttribute()
    {
        $name = $this->attributes['filename'];
        $path = "attachments/{$name}";

        return Storage::disk('public')->exists($path) ? Storage::disk('public')->url($path) : $name;
    }

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
