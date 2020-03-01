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
    public function test_a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'A Cool Book',
            'author'=>'John Doe'
        ]);
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function test_title_is_required()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'John Doe'
        ]);
        $response->assertSessionHasErrors('title');
    }

    public function test_author_is_required()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'A cool post',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $response = $this->post('/books/'. $book->id, [
            'title' => 'A new title',
            'author' => 'John Doe'
        ]);

        $this->assertEquals('A new title', Book::first()->title);
        $this->assertEquals('John Doe', Book::first()->author);
    }

    public function test_a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $this->assertCount(1, Book::all());
        $response = $this->delete('/books/'. $book->id);
        $this->assertCount(0,Book::all());
        $response->assertRedirect('books');

    }
}
