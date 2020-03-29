<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Genre;
use App\LikeDislike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MovieController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($title, $genre)
    {

        if($title!="false"){
            $movies =  Movie::with('likes')->with('genres')->where('title', 'like', "%{$title}%")->paginate(5);
            $movies->each(function ($item, $key) {
                $this->generateLikes($item);
            });
            
            return $movies;
        }
        else if($genre != "false"){  
            $genres = Genre::with('movies')->where('name', '=', $genre)->first();
            $movies = $genres->movies()->paginate(5);

            return $movies;

        }
        $movies =  Movie::with('likes')->with('genres')->paginate(5);
        $movies->each(function ($item, $key) {
            $this->generateLikes($item);
            
        });
        
        return $movies;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::with('genres')->find($id);
        $movie->increment('visited');
        $this->generateLikes($movie);
        return $movie;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function likeDislikeMovie(Request $request, $movieId){
        
        $like = $request['like'];
        $userId= auth()->user()["id"];

        $likeDislike = LikeDislike::updateOrCreate(
            ['user_id' => $userId, 'movie_id' => $movieId],
            ['liked' => ($like==1), 'disliked'=> ($like==0) ]
        );

        $movieToUpdate =  Movie::with('likes')->find($movieId);
        return $this->generateLikes($movieToUpdate);

    }

    public function generateLikes($movieToUpdate){
        $allLikes = count($movieToUpdate->likes->where('liked', 1));
        $allDislikes = count($movieToUpdate->likes->where('disliked', 1));
        $movieToUpdate['likesNumber'] = $allLikes;
        $movieToUpdate['dislikesNumber'] = $allDislikes;
        return $movieToUpdate;

    }
}
