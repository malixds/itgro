<?php

namespace App\Http\Resources;

use App\Models\Author;
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
            "name" => $this->name,
            "total_characters" => $this->total_characters,
            "author" => $this->author,
            "annotation" => $this->annotation,
            "published_at" => $this->published_at,
        ];
    }
}
