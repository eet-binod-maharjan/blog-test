<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
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
       $this->assertEquals(now(), Reservation::first()->checked_out_at);
   }

   public function test_only_signed_in_users_can_check_out_a_book()
   {
        $book = factory(Book::class)->create();
        $response = $this->post('/checkout/' . $book->id);
        $response->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
   }
   public function test_only_real_books_can_be_checked_out()
   {
    $book = factory(Book::class)->create();
    $this->actingAs($user = factory(User::class)->create())
    ->post('/checkout/'. 123)
    ->assertStatus(404);
    $this->assertCount(0, Reservation::all());

   }

   public function test_a_book_can_be_check_in_by_a_signed_in_user()
    {

        $this->withoutExceptionHandling();
       $book = factory(Book::class)->create();
       $this->actingAs($user = factory(User::class)->create())
       ->post('/checkout/'.$book->id);

       $this->actingAs($user)
       ->post('/checkin/'.$book->id);

       $this->assertCount(1, Reservation::all());
       $this->assertEquals($user->id, Reservation::first()->user_id);
       $this->assertEquals($book->id, Reservation::first()->book_id);
       $this->assertEquals(now(), Reservation::first()->checked_out_at);
       $this->assertEquals(now(), Reservation::first()->checked_in_at);

    }


   public function test_only_signed_in_users_can_check_in_a_book()
   {
        $book = factory(Book::class)->create();
        $this->actingAs($user = factory(User::class)->create())
        ->post('/checkout/'.$book->id);
        Auth::logout();

        $response = $this->post('/checkin/' . $book->id);
        $response->assertRedirect('/login');

        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);
   }

   public function test_a_404_is_thrown_if_a_book_is_not_check_out_first()
   {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
        ->post('/checkin/'.$book->id)
        ->assertStatus(404);

        $this->assertCount(0, Reservation::all());

   }
}
