<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\EditAuthorRequest;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Author\AuthorResourceCollection;
use App\Http\Resources\Author\AuthorWithBooksResource;
use App\Interfaces\IAuthorRepository;
use App\Models\Author;

class AuthorController extends Controller
{
    public function __construct(private IAuthorRepository $repository)
    {
    }
    public function authorsAll()
    {
        $authors = $this->repository->get();
        return new AuthorResourceCollection(new AuthorWithBooksResource($authors));
//        return new AuthorResourceCollection(new AuthorResource($authors)); // ресурс без списка книг
    }
    public function authorOne(Author $author)
    {
        $author = $this->repository->findOrFail($author->id);
        return new AuthorWithBooksResource($author);
//        return new AuthorResource($author); // ресурс без списка книг
    }
    public function authorCreate(CreateAuthorRequest $request)
    {
        $author = $this->repository->create($request->validated());
        return new AuthorWithBooksResource($author); // с книгами
//        return new AuthorResource($author); // без книг
    }
    public function authorUpdate(EditAuthorRequest $request, Author $author)
    {
        if ($this->repository->update($request->validated(), $author->id)) {
            return response()->json(["Author updated", 'author' => $author->fresh()]);
        }
        return response()->json(['message' => 'Error'], 400);
    }
}
