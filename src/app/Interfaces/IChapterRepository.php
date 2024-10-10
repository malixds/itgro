<?php

namespace App\Interfaces;

use App\Models\Chapter;

interface IChapterRepository
{
    public function create(array $data): ?Chapter;
    public function update(array $data, int $id): int;

}
