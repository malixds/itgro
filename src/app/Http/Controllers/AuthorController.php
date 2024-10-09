<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\EditAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorResourceCollection;
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
        return new AuthorResourceCollection(new AuthorResource($authors));
    }
    public function authorOne(Author $author)
    {
        $author = $this->repository->findOrFail($author->id);
        return new AuthorResource($author);
    }
    public function authorCreate(CreateAuthorRequest $request)
    {
        $author = $this->repository->create($request->validated());
        return new AuthorResource($author);
    }
    public function authorUpdate(EditAuthorRequest $request, Author $author)
    {
        if ($this->repository->update($request->validated(), $author->id)) {
            return response()->json(["Author updated", 'author' => $author->fresh()]);
        }
        return response()->json(['message' => 'Error'], 400);
    }
}
