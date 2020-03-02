<?php

namespace Tests\Unit;

use App\Author;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    public function test_an_author_id_is_recorded()
    {
        Book::Create([
            'title'=>'Cool test',
            'author_id'=>1
        ]);
        $this->assertCount(1, $author = Book::all());
    }

}
