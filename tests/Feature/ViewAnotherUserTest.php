<?php

namespace Tests\Feature;

use App\User;
use App\Tweet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewAnotherUserTest extends TestCase
{

    use DatabaseMigrations;

    public function test_view_another_users_tweet()
    {
        $this->withExceptionHandling();
        $user = factory(User::class)->create(['name'=>'johndoe']);
        $tweet = factory(Tweet::class)->make([
            'body'=>'My tweet body'
        ]);

        $user->tweets()->save($tweet);
        $response = $this->get('/johndoe');
        $response->assertViewIs('users.show');
        $response->assertViewHas('tweets');
        $response->assertSee("My tweet body");

    }
}
