<?php

namespace Tests\Unit;

use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_only_name_is_required_to_create_author()
    {
        // Author::firstOrCreate(['name'=>'John Doe']);
        $author = factory(Author::class)->create();
        $this->assertCount(1, Author::all());
    }
}
