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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/article/new', 'ArticleController@new')->name('article.new')->middleware('auth');

Route::post('/article/create', 'ArticleController@create')->name('article.create');

Route::get('/article/show/{id}', 'ArticleController@show')->name('article.show')->where('id', '\d+');
