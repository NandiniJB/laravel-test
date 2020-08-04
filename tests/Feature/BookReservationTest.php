<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
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
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Nandini'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function test_a_title_is_required() {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Nandini'
        ]);
        $response->assertSessionHasErrors('title');
    }

    public function test_a_author_is_required() {
        $response = $this->post('/books', [
            'title' => 'Cool Book title',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated() {
        $this->withoutExceptionHandling();
        
        $this->post('/books', [
            'title' => 'Cool Book title',
            'author' => 'Nandini'
        ]);

        $book = Book::first();
        
        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}
