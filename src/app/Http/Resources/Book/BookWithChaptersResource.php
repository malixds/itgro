<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookWithChaptersResource extends JsonResource
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
            "total_characters" => $this->total_characters,
            "chapters" => $this->chapters,
            "annotation" => $this->annotation,
            "published_at" => $this->published_at->format('d.m.Y'),
        ];
    }
}
