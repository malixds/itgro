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

    public function update(array $data, int $id): int
    {
        return Chapter::query()->find($id)->update($data);
    }

    public function find(int $id): ?Chapter
    {
        return Chapter::query()->where('id', $id)->with('book')->first();
    }
}
