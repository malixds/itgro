<?php

namespace App\Http\Requests;

use App\Rules\PublicationDateAfterAuthorBirthday;
use Illuminate\Foundation\Http\FormRequest;

class CreateAuthorRequest extends FormRequest
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
            "name" => "required|string|min:2|max:40",
            "information" => "nullable|max:1000",
            "birthday" => [
                "date_format:d-m-Y",
            ],
        ];
    }
}
