<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\User;
use App\LikeDislike;
use App\Movie;

class LikeDislikeTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_like_movie(){
        Event::fake();
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        factory(Movie::class)->create();

        $this->post('like/1', ["like"=>0]);

        $this->assertCount(1, LikeDislike::all());


    }

    public function test_that_user_cant_like_movie_twice(){
        Event::fake();
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        factory(Movie::class)->create();

        $this->post('like/1', ["like"=>0]);
        $this->post('like/1', ["like"=>0]);

        $this->assertCount(1, LikeDislike::all());
    }
}
