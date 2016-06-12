<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/post/{id}', ['uses'=> 'AdminPostsController@post', 'as'=>'home.post']);

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware'=>'admin'], function() {

    Route::resource('admin/users' , 'AdminUsersController');
    Route::get('/admin', function () {
        return view('admin.index');
    });
    Route::resource('admin/posts' , 'AdminPostsController');
    Route::resource('admin/categories' , 'AdminCategoriesController');
    Route::resource('admin/media' , 'AdminMediasController');
    Route::resource('admin/comments' , 'PostCommentsController');
    Route::resource('admin/comments/replies' , 'CommentRepliesController');
});

Route::group(['middleware'=>'auth'], function() { // пути и формы будут доступны только для зарегистрированных пользователей

    Route::post('/comment/reply', 'CommentRepliesController@createReply');
});

Route::get('/test ', function() {
    $user=App\User::find(1);
    echo $user->role->name;
});