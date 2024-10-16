<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "information" => $this->information,
            "books_count" => $this->books_count,
            "birthday" => $this->birthday,
        ];
    }
}
