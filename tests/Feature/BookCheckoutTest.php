<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_checked_out_by_signed_in_user()
   {
       $this->withoutExceptionHandling();
       $book = factory(Book::class)->create();
       $this->actingAs($user = factory(User::class)->create())
       ->post('/checkout/'.$book->id);

       $this->assertCount(1, Reservation::all());
       $this->assertEquals($user->id, Reservation::first()->user_id);
       $this->assertEquals($book->id, Reservation::first()->book_id);
       $this->assertNotNull(Reservation::first()->checked_in_at);
       $this->assertEquals(now(), Reservation::first()->checked_in_at);
   }
}
