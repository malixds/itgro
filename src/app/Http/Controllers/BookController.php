<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\EditBookRequest;
use App\Http\Resources\Book\BookCreateResource;
use App\Http\Resources\Book\BookFullResource;
use App\Http\Resources\Book\BookFullResourceCollection;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Book\BookResourceCollection;
use App\Interfaces\IBookRepository;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{

    //  BookFullResource - с автором и главами
    //  BookWithAuthorResource - с автором
    //  BookWithChaptersResource - c главами
    //  BookResource - только информация о книге

    public function __construct(private IBookRepository $repository)
    {
    }
    public function bookCreate(CreateBookRequest $request): JsonResponse|BookCreateResource
    {
        $book = $this->repository->create($request->validated());
        if ($book) {
            return new BookCreateResource($book);
        }
        return response()->json(['message' => 'Ошибка создания книги'], 400);
    }
    public function bookUpdate(EditBookRequest $request, Book $book): JsonResponse
    {
        if ($this->repository->update($request->validated(), $book->id)) {
            return response()->json(["Книга обновлена", 'book' => $book->fresh()]);
        }
        return response()->json(['message' => 'Ошибка при обновлении пользователя'], 400);
    }
    public function booksAll(): BookFullResourceCollection
    {
        $books = $this->repository->get();
        return new BookFullResourceCollection(new BookFullResource($books));
    }

    public function bookOne(Book $book): BookFullResource|JsonResponse
    {
        $book = $this->repository->findOrFail($book->id);
        if ($book) {
            return new BookFullResource($book);
        }
        return response()->json(['message' => 'Книга не найдена'], 404);
    }
}
