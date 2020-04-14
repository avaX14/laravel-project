<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        factory(Movie::class)->create();

        $response = $this->post('like/1', [
            "like"=>"1"
        ]);

        $this->assertCount(1, LikeDislike::all());
    }
}
