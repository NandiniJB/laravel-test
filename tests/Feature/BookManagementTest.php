<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_a_book_can_be_added_to_the_library() {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    public function test_a_title_is_required() {
        $response = $this->post('/books', [
            'title' => '',
            'author_id' => 'Nandini'
        ]);
        $response->assertSessionHasErrors('title');
    }

    public function test_a_author_is_required() {
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));
        $response->assertSessionHasErrors('author_id');
    }

    public function test_a_book_can_be_updated() {
        
        $this->post('/books', $this->data());

        $book = Book::first();
        
        $response = $this->patch($book->path(), [
            'title' => 'New title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals(3, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    public function test_a_book_can_be_deleted() {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertCount(1, Book::all()); //make sure a new book is added
        
        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    public function test_a_new_author_is_automatically_added() {
        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    public function data() {
        return [
            'title' => 'Cool Book title',
            'author_id' => 'Nandini'
        ];
    }
}
