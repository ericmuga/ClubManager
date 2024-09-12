<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntryTypeRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         // Access the ID of the entry type being updated
        $id = $this->route('id');

        return [
            'code' => 'required|string|max:255|unique:entry_types,code,' . $id, // Allow unique except for the current entry type
            'description' => 'required|string|max:255',
        ];
    }
}
