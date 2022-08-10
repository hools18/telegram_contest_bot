<?php

namespace App\Http\Requests\Panel\Contest;

use Illuminate\Foundation\Http\FormRequest;

class ContestDeleteRequest extends FormRequest
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
            'contest_id' => 'required|integer|exists:contests,id'
        ];
    }

    public function messages()
    {
        return [
            'contest_id.required' => 'ID обязателен к заполнению',
            'contest_id.integer' => 'ID должно быть числом',
            'contest_id.exists' => 'Указан не верный ID',
        ];
    }
}
