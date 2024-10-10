<?php

namespace App\Http\Requests;

use App\Rules\PublicationDateAfterAuthorBirthday;
use Illuminate\Foundation\Http\FormRequest;

class EditBookRequest extends FormRequest
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
            "name" => "min:2|max:100",
            "author_id" => "integer|exists:authors,id",
            "annotation" => "max:1000",
            "published_at" => [
                "date_format:d-m-Y",
                new PublicationDateAfterAuthorBirthday($this->author_id),
            ],
        ];
    }
}
