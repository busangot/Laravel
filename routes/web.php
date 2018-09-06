<?php

use Illuminate\Support\Facades\Redis;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     // redis has posts.all key exists 
//     // posts found then it will return all post without touching the database
//     if ($posts = Redis::get('posts.all')) {
//         return json_decode($posts);
//     }
 
//     // get all post
//     $posts = Post::all();
 
//     // store into redis
//     Redis::set('posts.all', $posts);
 
//     // return all posts
//     return $posts;
// });

Route::get('/', 'PagesController@index');
Route::get('/services', 'PagesController@services');
Route::resource('post', 'PostsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
