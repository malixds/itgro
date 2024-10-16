<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCreateValidAuthor(): void
    {
        $response = $this->postJson(route('author.create'), [
            'name' => 'John Doe',
            'information' => 'Some information about John.',
            'birthday' => '01-01-2000',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('authors', [
            'name' => 'John Doe',
        ]);
    }

    public function testCreateInvalidAuthor()
    {
        $response = $this->postJson(route('author.create'), [
            'name' => 'J', // Invalid name
            'information' => 'Some information about John.',
            'birthday' => '1980-01-01',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function testUpdateAuthor()
    {
        $author = Author::factory()->create([
            'name' => 'Maxim',
            'information' => 'Some information about John.',
            'birthday' => '01-01-2003',
        ]);

        $response = $this->putJson(route('author.update', ["author" => $author]), [
            'name' => 'Maxim',
            'information' => 'Updated information.',
            'birthday' => '02-02-2004',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', [
            'name' => 'Maxim',
        ]);
    }

    public function testCheckPaginatedAuthorList()
    {
        Author::factory()->count(30)->create();

        $response = $this->getJson(route('author.all'));

        $response->assertStatus(200);
        $this->assertCount(15, $response->json('data'));
    }

    public function testCheckGettingAuthorWithBooks()
    {
        $author = Author::factory()->create([
            'name' => 'Artem',
            'birthday' => '1980-01-01',
        ]);

        $author->books()->create([
            'name' => 'Book 1',
            'published_at' => "2000-01-01",
        ]);
        $author->books()->create([
            'name' => 'Book 2',
            'published_at' => "2010-01-01",
        ]);

        $response = $this->getJson(route('author', ['author' => $author]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'books_count',
                'books' => [],
            ],
        ]);
    }
}
