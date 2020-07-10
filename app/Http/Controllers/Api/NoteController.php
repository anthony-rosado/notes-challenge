<?php

namespace App\Http\Controllers\Api;

use App\Entities\Note;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Note\StoreNoteRequest;
use App\Http\Resources\Api\NoteCollection;
use App\Http\Resources\Api\NoteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => ['sometimes', 'integer'],
        ]);

        $perPage = $request->get('per_page') ?? 10;
        $groupId = $request->get('group_id');

        $notes = Note::where('group_id', $groupId)->paginate($perPage);

        return new NoteCollection($notes);
    }

    public function show(Request $request, $id)
    {
        $groupId = $request->get('group_id');

        $note = Note::with('attachments')
            ->where('id', $id)
            ->where('group_id', $groupId)
            ->first();

        if (is_null($note)) {
            return ApiResponse::failed(null, __('messages.note.not_available'));
        }

        return ApiResponse::success(new NoteResource($note));
    }

    public function store(StoreNoteRequest $request)
    {
        /**@var Note $note*/
        $note = Note::make($request->validated());
        $note->user()->associate(Auth::id());
        $note->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                $relativePath = Storage::disk('public')->putFile('attachments', $image);

                $note->attachments()->create([
                    'filename' => $this->getFilenameFromPath($relativePath),
                ]);
            }
        }

        return ApiResponse::created(new NoteResource($note), __('messages.note.created'));
    }

    private function getFilenameFromPath($path)
    {
        $pathChunks = explode('/', $path);

        return $pathChunks[count($pathChunks) - 1];
    }
}
