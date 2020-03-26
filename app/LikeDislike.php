<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeDislike extends Model
{
    protected $table = 'like_dislike';
    protected $fillable = array('movie_id', 'user_id', 'liked', 'disliked');
    public $timestamps = false;

    public function movie()
    {
        return $this->belongsTo('App\Movie');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
