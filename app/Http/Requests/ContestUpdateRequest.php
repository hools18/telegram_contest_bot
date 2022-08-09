<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string',
            'short_name' => 'required|string|max:120',
            'description' => 'required|string',
            'start_date' => 'required|date_format:d.m.Y H:i',
            'end_date' => 'required|date_format:d.m.Y H:i',
            'image' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'name.string'           => 'Название должно быть строкой',
            'name.required'        => 'Название обязательно к заполнению',
            'short_name.string'        => 'Короткое название должно быть строкой',
            'short_name.required'        => 'Короткое название обязательно к заполнению',
            'short_name.max'        => 'Максимальная длина короткого названия 60 символов',
            'description.string'           => 'Описание должно быть строкой',
            'description.required'        => 'Описание обязательно к заполнению',
            'start_date.required'        => 'Дата начала обязательна к заполнению',
            'start_date.date_format'        => 'Дата начала обязательна к заполнению',
            'end_date.required'        => 'Дата завершения обязательна к заполнению',
            'end_date.date_format'        => 'Неверный формат даты',
            'image.image'        => 'Можно загружать только изображения',
        ];
    }
}
