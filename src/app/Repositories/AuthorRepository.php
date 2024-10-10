<?php

namespace App\Repositories;

use App\Interfaces\IAuthorRepository;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorRepository implements IAuthorRepository
{
    private function convertToValidFormat(array $data)
    {
        if ($data['birthday']) {
            $data['birthday'] = Carbon::createFromFormat('d-m-Y', $data['birthday']);
        }
        return $data;
    }
    public function create(array $data): ?Author
    {
        $data = $this->convertToValidFormat($data);
        return Author::query()->create($data);
    }

    public function update(array $data, int $id): int
    {
        $data = $this->convertToValidFormat($data);
        return Author::query()->where('id', $id)->update($data);
    }

    public function get(): LengthAwarePaginator
    {
        return QueryBuilder::for(Author::class)
            ->with('books')
            ->withCount('books')
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
