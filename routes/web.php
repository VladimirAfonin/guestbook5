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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// user part.
Route::group(['middleware' => 'web'], function() {
    Route::resource('/', 'CommentController@execute');
    Route::post('/addItem', 'CommentController@addItem');
});

// admin part.
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::resource('/', 'CommentController');
    Route::post('/editItem', 'CommentController@editItem');
    Route::post('/deleteItem', 'CommentController@deleteItem');
});

Route::get('/home', 'HomeController@index');
