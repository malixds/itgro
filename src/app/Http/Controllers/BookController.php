<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\EditAuthorRequest;
use App\Http\Requests\EditBookRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorResourceCollection;
use App\Http\Resources\BookCreateResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookResourceCollection;
use App\Interfaces\IBookRepository;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function __construct(private IBookRepository $repository)
    {
    }
    public function bookCreate(CreateBookRequest $request)
    {
        $book = $this->repository->create($request->validated());
        return new BookCreateResource($book);
    }
    public function bookUpdate(EditBookRequest $request, Book $book)
    {
        if ($this->repository->update($request->validated(), $book->id)) {
            return response()->json(["Book updated", 'book' => $book->fresh()]);
        }
        return response()->json(['message' => 'Error'], 400);
    }
    public function booksAll(): BookResourceCollection
    {
        $books = $this->repository->get();
        return new BookResourceCollection(new BookResource($books));
    }

    public function bookOne(Book $book)
    {
        $book = $this->repository->findOrFail($book->id);
        if ($book) {
            return new BookResource($book);
        }
        abort(404);
    }
}
