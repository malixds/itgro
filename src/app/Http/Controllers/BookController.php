<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\EditBookRequest;
use App\Http\Resources\Book\BookCreateResource;
use App\Http\Resources\Book\BookFullResource;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Book\BookResourceCollection;
use App\Interfaces\IBookRepository;
use App\Models\Book;

class BookController extends Controller
{

    //  BookFullResource - с автором и главами
    //  BookWithAuthorResource - с автором
    //  BookWithChaptersResource - c главами
    //  BookResource - только информация о книге

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
        return new BookResourceCollection(new BookFullResource($books));
    }

    public function bookOne(Book $book)
    {
        $book = $this->repository->findOrFail($book->id);
        if ($book) {
            return new BookFullResource($book);
        }
        abort(404);
    }
}
