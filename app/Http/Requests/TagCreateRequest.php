<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagCreateRequest extends FormRequest
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
            'name' => 'unique:tags|required|min:3|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Kolom name wajib diisi',
            'name.max' => 'Kolom name Maksimal :max Karakter',
            'name.min' => 'Kolom name Minimal :min Karakter',
            'name.unique' => 'Nama Tag sudah tersedia',
        ];
    }
}
