<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchList extends Model
{
    protected $table = 'watch_lists';

    public function movies(){
        return $this->belongsToMany('App\Movie');
    }

}
