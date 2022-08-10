<?php

namespace App\Http\Requests\Panel\Contest;

use Illuminate\Foundation\Http\FormRequest;

class ContestImageUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image',
        ];
    }

    public function messages(): array
    {
        return [

            'image.required'        => 'Обязательно выберите изображение',
            'image.image'        => 'Можно загружать только изображения',
        ];
    }
}
