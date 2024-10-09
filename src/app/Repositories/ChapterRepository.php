<?php

namespace App\Repositories;

use App\Interfaces\IChapterRepository;
use App\Models\Chapter;

class ChapterRepository implements IChapterRepository
{
    public function create(array $data): ?Chapter
    {
        return Chapter::query()->create($data);
    }
}
