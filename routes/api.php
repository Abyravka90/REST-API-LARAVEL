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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/v1/posts/store', 'api\v1\PostsController@store');
Route::get('/v1/posts', 'api\v1\PostsController@index');
Route::get('/v1/posts/{id?}', 'api\v1\PostsController@show');
Route::post('/v1/posts/update', 'api\v1\PostsController@update');
Route::delete('/v1/posts/{id?}', 'api\v1\PostsController@destroy');