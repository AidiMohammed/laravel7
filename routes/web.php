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

Route::get('contact',function(){
        return view('contact');
})->name('contact');

route::view('factories','factories.create')->name('factories')->middleware('can:factories.createPosts');
route::get('secret','HomeController@secret')->name('secret')->middleware('can:secret.page');
route::post('factories/create/posts','FactoryController@createPosts')->name('factories.storePosts');

route::get('posts/tags/{tag}' , 'TagController@index')->name('posts.tag.index');

Route::get('posts/archive','PostsController@archive')->middleware('can:isAdmin');
Route::get('posts/all','PostsController@all')->middleware('can:isAdmin');
Route::patch('posts/{id}/restore','PostsController@restore')->name('post.restore');
Route::delete('posts/{id}/forceDelete','PostsController@forceDelete')->name('posts.forceDelete');

Route::post('answer/{comment}','CommentController@replyComment')->name('comment.answer');
Route::delete('answer/{answer}','CommentController@deleteAnswer')->name('comment.answer.delete');

Route::resource('user','UserController')->only(['show','edit','update']);
Route::resource('user.comment','UserCommentController')->only(['store']);

Route::resource('posts','PostsController');
Route::resource('comment','CommentController')->only(['destroy','edit','update']);
Route::post('comment/store/{post}','CommentController@storeMyComment')->name('comments.storeMyComment');
Auth::routes();

Route::post('email/contact','EmailController@create')->name('email.contact.us');

Route::get('home', 'HomeController@index')->name('home');
