<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleAdminEditRequest extends FormRequest
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
            'title' => 'max:70|required',
            'description' => 'max:250|required',
            'content' => 'required',
            'photo' => 'image|max:5000',
            'duration' => 'integer|min:1|required',
            'author_id' => 'required',
            'status' => 'required',
            'slug' => 'unique',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Kolom title wajib diisi',
            'title.max' => 'Kolom title Maksimal :max Karakter',
            'description.required' => 'Kolom description wajib diisi',
            'description.max' => 'Kolom description Maksimal :max Karakter',
            'content.required' => 'Kolom content wajib diisi',
            'photo.image' => 'File Wajib Bertipe jpg, jpeg, png, bmp, gif, svg, or webp',
            'photo.max' => 'Ukuran File Maksimal :max KB',
            'duration.min' => 'Durasi minimal :min menit',
            'duration.integer' => 'Durasi berbentuk bilangan bulat',
            'duration.required' => 'Kolom duration wajib diisi',
            'author_id.required' => 'Kolom author_id wajib diisi',
            'status.required' => 'Kolom status wajib diisi',
        ];
    }
}
