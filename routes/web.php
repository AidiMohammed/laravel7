<?php

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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

route::view('/factories','factories.create')->name('factories.createPosts');
route::post('/factories/create/posts','FactoryController@createPosts')->name('factories.storePosts');

Route::get('/home','HomeController@homePage')->name('home.homePage');
Route::get('/about','HomeController@aboutPage')->name('home.aboutPage');

Route::get('/posts/archive','PostsController@archive');
Route::get('/posts/all','PostsController@all');
Route::patch('/posts/{id}/restore','PostsController@restore');
Route::delete('/posts/{id}/forceDelete','PostsController@forceDelete');

Route::resource('posts','PostsController');
Route::resource('comment','CommentController')->only(['destroy']);
Route::post('comment/store/{post}','CommentController@storeMyComment')->name('comments.storeMyComment');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
