<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChapterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCreateChapter()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);
        $response = $this->postJson(route('chapter.create'), [
            'book_id' => $book->id,
            'name' => 'Chapter 1',
            'content' => 'This is the content of chapter 1.',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('chapters', [
            'name' => 'Chapter 1',
            'content' => 'This is the content of chapter 1.',
            'book_id' => $book->id,
        ]);
    }

    /** @test */
    public function testUpdateChapter()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);
        $chapter = Chapter::factory()->create(['book_id' => $book->id]);

        $response = $this->putJson(route('chapter.update', ['chapter' => $chapter]), [
            'book_id' => $book->id,
            'name' => 'Updated Chapter',
            'content' => 'Updated content.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('chapters', [
            'id' => $chapter->id,
            'book_id' => $book->id,
            'name' => 'Updated Chapter',
            'content' => 'Updated content.',
        ]);
    }
}
