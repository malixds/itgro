<?php

namespace Tests\Feature;

use App\Interfaces\IAuthorRepository;
use App\Interfaces\IBookRepository;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function testCreateBook()
    {
        $author = Author::factory()->create();

        $response = $this->postJson(route('book.create'), [
            'author_id' => $author->id,
            'name' => 'Test Book Title',
            'annotation' => 'This is a test annotation.',
            'published_at' => '01-01-2023',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', [
            'name' => 'Test Book Title',
            'author_id' => $author->id,
        ]);
    }

    /** @test */
//    public function checkValidateRequiredFieldOfBookCreating()
//    {
//        $response = $this->postJson(route('book.create'), []);
//
//        $response->assertStatus(422);
//        $response->assertJsonValidationErrors(['author_id', 'title']);
//    }

    /** @test */
    public function testCheckValidateRequiredFieldOfBookCreating()
    {
        $author = Author::factory()->create();

        $response = $this->postJson(route('book.create'), [
            'author_id' => $author->id,
            'name' => 'A', // short
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function testBookPagination()
    {
        $author = Author::factory()->create();
        Book::factory()->count(15)->create(['author_id' => $author->id]);
        $response = $this->getJson('/api/books?page=1');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data'); // 10 at the one page
    }

    /** @test */
    public function testBookWithAuthor()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);

        $response = $this->getJson(route('book', ['book' => $book]));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $book->name]);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'total_characters',
                'author' => [],
            ],
        ]);
    }

    /** @test */
    public function testCheckInvalidDateFormat()
    {
        $author = Author::factory()->create();

        $response = $this->postJson(route('book.create'), [
            'author_id' => $author->id,
            'name' => 'Test Book Title',
            'published_at' => '2023-01-01',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['published_at']);
    }
}
