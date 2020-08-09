<?php

namespace Tests\Unit;

use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_only_name_is_required_to_create_an_author()
    {
        Author::firstOrCreate([
            'name' => 'Umesh'
        ]);

        $this->assertCount(1, Author::all());
    }
}
