<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorWithBooksResource extends JsonResource
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
            "books" => $this->books,
            "created_at" => $this->created_at->isoFormat('D MMMM YYYY')
        ];
    }
}
