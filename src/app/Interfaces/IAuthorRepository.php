<?php

namespace App\Interfaces;

use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IAuthorRepository
{
    public function create(array $data): ?Author;
    public function update(array $data, int $id): int;
    public function get(): LengthAwarePaginator;
    public function findOrFail(int $id): ?Author;
    public function find(int $id): ?Author;
}
