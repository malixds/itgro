<?php

namespace App\Repositories;

use App\Interfaces\IBookRepository;
use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class BookRepository implements IBookRepository
{
    public function get(): LengthAwarePaginator
    {
        return QueryBuilder::for(Book::class)
            ->with('author')
            ->paginate(10);
    }

    public function create(array $data): ?Book
    {
        $data['published_at'] = Carbon::createFromFormat('d-m-Y', $data['published_at']);
        return Book::query()->create($data);
    }

    public function update(array $data, int $id): int
    {
        return Book::query()->where('id', $id)->update($data);
    }
    public function findOrFail(int $id): ?Book
    {
        return Book::query()->where('id', $id)->with('author')->first();
    }
}
