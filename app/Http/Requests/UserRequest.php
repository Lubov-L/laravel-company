<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:40',
            'surname' => 'required|string|min:3|max:40',
            'phone' => ['required', 'regex:/\+7\d{10}/'],
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }
}
