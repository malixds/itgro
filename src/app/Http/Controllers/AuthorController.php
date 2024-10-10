<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\EditAuthorRequest;
use App\Http\Resources\Author\AuthorResourceCollection;
use App\Http\Resources\Author\AuthorWithBooksResourceCollection;
use App\Http\Resources\Author\AuthorWithBooksResource;
use App\Interfaces\IAuthorRepository;
use App\Models\Author;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function __construct(private IAuthorRepository $repository)
    {
    }

    public function authorsAll(): AuthorWithBooksResourceCollection|AuthorResourceCollection
    {
        $authors = $this->repository->get();
        return new AuthorWithBooksResourceCollection(new AuthorWithBooksResource($authors));
//        Можно вернуть информацию только об авторах (без книг)
//        return new AuthorResourceCollection(new AuthorResource($authors));
    }

    public function authorOne(Author $author): JsonResponse|AuthorWithBooksResource
    {
        $author = $this->repository->findOrFail($author->id);
        if ($author) {
            return new AuthorWithBooksResource($author);
        }
        return response()->json(['message' => 'Автор не найден'], 404);
    }

    public function authorCreate(CreateAuthorRequest $request): JsonResponse|AuthorWithBooksResource
    {
        $author = $this->repository->create($request->validated());
        if ($author) {
            return new AuthorWithBooksResource($author);
        }
        return response()->json(['message' => 'Ошибка создания автора'], 400);
    }


    public function authorUpdate(EditAuthorRequest $request, Author $author): JsonResponse
    {
        if ($this->repository->update($request->validated(), $author->id)) {
            return response()->json(["Автор обновлен", 'author' => $author->fresh()]);
        }
        return response()->json(['message' => 'Ошибка при обновлении автора'], 400);
    }
}
