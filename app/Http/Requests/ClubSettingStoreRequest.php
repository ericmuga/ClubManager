<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubSettingStoreRequest extends FormRequest
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
            'club_name' => 'required|string|max:255',
            'change_log_active' => 'nullable|boolean',
            'default_currency' => 'nullable|string|max:10',
            // 'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => 'required|boolean',
            'email'=>'nullable|email',
            'address'=>'nullable',
            'telephone'=>'nullable',
            'slogan'=>'nullable',
            'pin'=>'nullable|max:11',
            'dispatch_emails'=>'nullable|boolean',
 ];
    }
}
