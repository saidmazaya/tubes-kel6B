<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1000',
            'username' => 'unique:users,username,' . $this->id . '|required|max:30|min:2',
            'email' => 'unique:users,email,' . $this->id . '|required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal :max karakter',
            'photo.image' => 'File Wajib Bertipe jpg, jpeg, png, bmp, gif',
            'photo.max' => 'Ukuran Foto Maksimal :max KB',
            'username.required' => 'Username wajib diisi',
            'username.max' => 'Username maksimal :max karakter',
            'username.min' => 'Username minimal 1 karakter',
            'username.unique' => 'Username tidak tersedia',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email tidak tersedia',
        ];
    }
}
