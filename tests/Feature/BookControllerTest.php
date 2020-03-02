<?php

namespace Tests\Feature;

use App\Author;
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
        $response = $this->post('/books', $this->data());
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function test_title_is_required()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', array_merge($this->data(),['title'=>'']));
        $response->assertSessionHasErrors('title');
    }

    public function test_author_is_required()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books',array_merge($this->data(), ['author_id'=>'']));
        $response->assertSessionHasErrors('author_id');
    }

    public function test_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $response = $this->post('/books/'. $book->id, array_merge($this->data(), ['title'=>'A new title']));

        $this->assertEquals('A new title', Book::first()->title);
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

    public function test_a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Cool Title',
            'author_id' => 'Victor'
        ]);
        $book = Book::first();
        $author = Author::first();
        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id, $book->author_id);

    }

    public function data()
    {
      return  [
            'title' => 'A Cool Book',
            'author_id'=>'John Doe'
      ];
    }
}
