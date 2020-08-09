<?php

namespace Tests\Unit;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_an_author_id_is_recoreded()
    {
        Book::create([
            'title' => 'Cool title',
            'author_id' => 1,
        ]);

        $this->assertCount(1, Book::all());
    }
}
