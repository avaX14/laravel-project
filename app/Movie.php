<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use LikeDislike;

class Movie extends Model
{
    //

    protected $fillable = array('title', 'description', 'image_url');

    public function likes()
    {
        return $this->hasMany('App\LikeDislike');
    }

    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'watch_lists', 'movie_id','user_id');
    }

}
