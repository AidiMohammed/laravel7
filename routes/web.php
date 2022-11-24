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

route::view('/factories','factories.create')->name('factories')->middleware('can:factories.createPosts');
route::get('/secret','HomeController@secret')->name('secret')->middleware('can:secret.page');
route::post('/factories/create/posts','FactoryController@createPosts')->name('factories.storePosts');

Route::get('/posts/archive','PostsController@archive');
Route::get('/posts/all','PostsController@all');
Route::patch('/posts/{id}/restore','PostsController@restore');
Route::delete('/posts/{id}/forceDelete','PostsController@forceDelete');

Route::resource('posts','PostsController');
Route::resource('comment','CommentController')->only(['destroy']);
Route::post('comment/store/{post}','CommentController@storeMyComment')->name('comments.storeMyComment');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
