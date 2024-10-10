<?php

namespace App\Repositories;

use App\Interfaces\IAuthorRepository;
use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorRepository implements IAuthorRepository
{
    public function create(array $data): ?Author
    {
        return Author::query()->create($data);
    }

    public function update(array $data, int $id): int
    {
        return Author::query()->where('id', $id)->update($data);
    }

    public function get(): LengthAwarePaginator
    {
        return QueryBuilder::for(Author::class)
            ->with('books')
            ->withCount('books') // Добавляем количество книг
            ->orderBy('books_count', 'desc')
            ->paginate(15);
    }

    public function findOrFail(int $id): ?Author
    {
        return Author::query()->where('id', $id)->with('books')->first();
    }

    public function find(int $id): ?Author
    {
        return Author::query()->find($id);
    }
}
