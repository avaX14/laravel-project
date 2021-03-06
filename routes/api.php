<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('me', 'Auth\AuthController@me');
    Route::post('register', 'Auth\RegisterController@create');
});

Route::get('movies/{title}/{genre}', 'Api\MovieController@index');
Route::get('movies/watchList', 'Api\MovieController@watchList');
Route::get('movie/{id}', 'Api\MovieController@show');
Route::get('genres', 'Api\GenreController');
Route::get('movies/popularMovies', 'Api\MovieController@getPopularMovies');
Route::post('movies/relatedMovies', 'Api\MovieController@getRelatedMovies');
Route::post('movies/uploadImage', 'Api\MovieController@uploadImage');

Route::post('like/{movieId}', 'Api\MovieController@likeDislikeMovie');
Route::post('movies/addToWatchList/{movieId}', 'Api\MovieController@addToWatchList');
Route::post('movies/removeFromWatchList/{movieId}', 'Api\MovieController@removeFromWatchList');
Route::post('movies/markAsWatched/{movieId}', 'Api\MovieController@markMovieAsWatched');
Route::post('movies/createMovie', 'Api\MovieController@store');
Route::post('movies/uploadImage', 'Api\MovieController@storeImage');

Route::get('comments/{movieId}', 'Api\CommentController@index');
Route::post('comments/{movieId}','Api\CommentController@store');
