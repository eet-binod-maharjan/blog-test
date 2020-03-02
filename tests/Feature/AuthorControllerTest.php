<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /**@test */
    public function test_an_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/author',$this->data());
        $this->assertCount(1, $author = Author::all());
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('2020/01/01', $author->first()->dob->format('Y/m/d'));
        $response->assertRedirect('author');

    }

    public function test_a_name_is_required()
    {
        $response = $this->post('/author', array_merge( $this->data(), ['name'=>""]));
        $response->assertSessionHasErrors('name');
    }

    public function test_a_dob_is_required()
    {
        $response = $this->post('/author', array_merge( $this->data(), ['dob'=>""]));
        $response->assertSessionHasErrors('dob');
    }

    private function data()
    {
        return [
            'name' => 'John Doe',
            'dob' => '2020/01/01'
        ];
    }

}
