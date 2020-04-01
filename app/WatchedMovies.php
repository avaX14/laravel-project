<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchedMovies extends Model
{
    public function movies(){
        return $this->belongsToMany('App\Movie');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
