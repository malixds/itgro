<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAuthorRequest extends FormRequest
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
            "name" => "string|min:2|max:40",
            "information" => "max:1000",
            "birthday" => "date_format:d-m-Y",
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => "Минимальный размер имени - 2 символа",
            "name.max" => "Максимальный размер имени - 40 символов",
            "information.max" => "Максимальный размер информации - 1000 символов",
            "birthday.date" => "Дата рождения должна быть корректной",
        ];
    }
}
