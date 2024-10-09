<?php

namespace App\Interfaces;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface IBookRepository
{

    public function create(array $data): ?Book;
    public function update(array $data, int $id): int;
    public function findOrFail(int $id): ?Book;
    public function get(): LengthAwarePaginator;

}
