<?php

namespace App\Providers;

use App\Interfaces\IAuthorRepository;
use App\Interfaces\IBookRepository;
use App\Interfaces\IChapterRepository;
use App\Repositories\AuthorRepository;
use App\Repositories\BookRepository;
use App\Repositories\ChapterRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthorRepository::class, AuthorRepository::class);
        $this->app->bind(IBookRepository::class, BookRepository::class);
        $this->app->bind(IChapterRepository::class, ChapterRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
