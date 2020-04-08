<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieImage extends Model
{
    public $timestamps = false;
    protected $fillable = array('movie_id', 'thumbnail', 'full_size');

    public function movie(){
        return $this->belongsTo('App\Movie');
    }
    
}
