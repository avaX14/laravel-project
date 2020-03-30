<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use LikeDislike;

class Movie extends Model
{
    //

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

}
