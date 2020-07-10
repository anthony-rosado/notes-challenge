<?php

namespace App\Http\Requests\Api\Note;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:10', 'max:70'],
            'description' => ['required', 'string', 'min:10', 'max:255'],
            'group_id' => ['required', 'integer', 'exists:groups,id'],
            'attachments.*' => ['required', 'image'],
        ];
    }
}
