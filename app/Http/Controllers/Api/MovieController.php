<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\LikeDislike;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($title=null)
    {
        if($title){
            return Movie::where('title', 'like', "%{$title}%")->paginate(5);
        }

        return Movie::paginate(5);

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
        return Movie::find($id);
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

        $allLikes = LikeDislike::where(['movie_id' => $movieId, 'liked' => 1])->get();
        $allDislikes = LikeDislike::where(['movie_id' => $movieId, 'disliked' => 1])->get();

        $movieToUpdate =  Movie::find($movieId);
        $movieToUpdate->likes = count($allLikes);
        $movieToUpdate->dislikes = count($allDislikes);
        $movieToUpdate->save();

        return $movieToUpdate;

    }
}
