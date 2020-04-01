<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Genre;
use App\LikeDislike;
use App\WatchList;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\CreateMovieRequest;

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
    public function store(CreateMovieRequest $request)
    {
        $request = $request->validated();

        return Movie::create([
            'title' => request('title'),
            'image_url' => request('image'),
            'description' => request('description')
        ]);
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
        $movie['watched'] = false;
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
        $userId = $this->getLoggedInUserId();

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

    public function watchList(){
        $userId = $this->getLoggedInUserId();
        $userMovies =  User::with('movies')->where('id', '=', $userId)->first();
        $userMovies->movies->each(function ($item, $key) {
                $item['watched'] = $item->pivot->watched;
                $this->generateLikes($item);
        });

        return $userMovies;
    }

    public function addToWatchList($movieId){
        $userId = $this->getLoggedInUserId();
        $user = User::find($userId);
        $user->movies()->attach($movieId);
    }

    public function removeFromWatchList($movieId){
        $userId = $this->getLoggedInUserId();
        $user = User::find($userId);
        $user->movies()->detach($movieId);
    }

    public function markMovieAsWatched($movieId){
        $userId = $this->getLoggedInUserId();
        $userMovies =  User::with('movies')->where('id', '=', $userId)->first();
        $userMovies->movies->each(function ($item, $key) use($movieId){
            if($item->id==$movieId){
                $item->pivot->watched = !($item->pivot->watched);
                $item->pivot->save();
            }
        });
        return $userMovies;
    }

    public function getLoggedInUserId(){
        return auth()->user()["id"];
    }

    public function getPopularMovies(){
        $movies =  Movie::get()->sortByDesc('visited')->values()->take(10);
        \Log::info($movies);
        return $movies;
        
    }
}
