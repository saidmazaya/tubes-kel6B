<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required|min:8|max:16',
            'new_password' => 'required|min:8|max:16',
            'repeat_password' => 'required|min:8|max:16',
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Password is required',
            'old_password.min' => 'Password must be at least 8 characters',
            'old_password.max' => 'Password can not exceed 16 characters',
            'new_password.required' => 'Password is required',
            'new_password.min' => 'Password must be at least 8 characters',
            'new_password.max' => 'Password can not exceed 16 characters',
            'repeat_password.required' => 'Password is required',
            'repeat_password.min' => 'Password must be at least 8 characters',
            'repeat_password.max' => 'Password can not exceed 16 characters',
        ];
    }
}
