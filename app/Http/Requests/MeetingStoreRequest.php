<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string'],
            'date' => ['required'],
            'venue' => ['required', 'string'],
            'topic' => ['required', 'string'],
            'host' => ['required', 'string'],
            'uuid' => ['nullable', 'string'],
            'meeting_no' => ['nullable', 'integer', 'gt:0'],
            'official_start_time' => ['required', 'string'],
            'official_end_time' => ['required', 'string'],
            'detail' => ['nullable', 'string'],
        ];
    }
}
