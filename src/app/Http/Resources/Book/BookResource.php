<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            "author_id" => $this->author->id,
            "total_characters" => $this->total_characters,
            "annotation" => $this->annotation,
            "published_at" => $this->published_at->format('d.m.Y'),
        ];
    }
}
