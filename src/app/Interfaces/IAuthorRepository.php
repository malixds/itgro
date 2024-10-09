<?php

namespace App\Interfaces;

use App\Models\Author;

interface IAuthorRepository
{
    public function create(array $data): ?Author;
    public function update(array $data, int $id): int;
    public function get();
    public function findOrFail(int $id): ?Author;
}
