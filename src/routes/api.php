<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChapterController;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Route;


Route::get('/authors', [AuthorController::class, 'authorsAll'])->name('author.all');
Route::get('/author/{author}', [AuthorController::class, 'authorOne'])->name('author');
Route::post('/author/create', [AuthorController::class, 'authorCreate'])->name('author.create');
Route::put('/author/update/{author}', [AuthorController::class, 'authorUpdate'])->name('author.update');

Route::post('/book/create', [BookController::class, 'bookCreate'])->name('book.create');
Route::put('/book/update', [BookController::class, 'bookUpdate'])->name('book.update');
Route::get('/books', [BookController::class, 'booksAll'])->name('book.all');
Route::get('/book/{book}', [BookController::class, 'bookOne'])->name('book');


Route::post('/chapter/create', [ChapterController::class, 'chapterCreate'])->name('chapter.create');
Route::put('/chapter/update/{chapter}', [ChapterController::class, 'chapterUpdate'])->name('chapter.update');

