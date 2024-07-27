<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
        return [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'email'=>'required|unique:users,email,except,id',
            'member_name'=>'required',
            'member_no'=>'required',
        ];
    }
}
