<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

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

    public function testUpdateBook()
    {
        $author = Author::factory()->create([
            'name' => 'Maxim',
            'information' => 'Some information about Maxim',
            'birthday' => '01-01-2003',
        ]);
        $book = Book::factory()->create([
            'name' => 'Nice book',
            'author_id' => $author->id,
            'annotation' => 'Some information about this book',
            'published_at' => '01-01-2010',
        ]);

        $response = $this->putJson(route('book.update', ["book" => $book]), [
            'name' => 'NIce book Maxim',
            'author_id' => $author->id,
            'annotation' => 'Updated information.',
            'published_at' => '03-02-2011',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', [
            'name' => 'NIce book Maxim',
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

    public function testGetBookWithChapters()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);
        Chapter::factory()->count(2)->create(['book_id' => $book->id]);
        $response = $this->getJson(route('book', ['book' => $book]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'total_characters',
                'chapters' => [],
            ],
        ]);
    }

    public function testGetBookFull()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);
        Chapter::factory()->count(2)->create(['book_id' => $book->id]);
        $response = $this->getJson(route('book', ['book' => $book]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'total_characters',
                'author' => [],
                'chapters' => [],
            ],
        ]);
    }
}
