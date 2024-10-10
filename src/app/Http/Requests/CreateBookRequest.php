<?php

namespace App\Http\Requests;

use App\Rules\PublicationDateAfterAuthorBirthday;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
            "name" => "required|min:2|max:100",
            "author_id" => "required|integer|exists:authors,id",
            "annotation" => "max:1000",
            "published_at" => [
                "required",
                "date_format:d-m-Y",
                new PublicationDateAfterAuthorBirthday($this->author_id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название - обязательное значения',
            'name.min' => 'Минимальная величина имени - 2',
            'name.max' => 'Максимальная величина имени - 2',
            'annotation.max' => "Максимальная величина аннотации - 1000 символов",
            'published_at.date_format:d-m-Y' => "Формат даты dd-mm-yyyy",
        ];
    }
}
