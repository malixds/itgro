<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookWithChaptersResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public $collects = BookWithChaptersResource::class;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
