<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::post('/article/create', 'ArticleController@create')->name('article.create')->middleware('auth');

Route::get('/article/show/{id}', 'ArticleController@show')->name('article.show')->where('id', '\d+');

Route::get('/article/list', 'ArticleController@list')->name('article.list');

Route::get('/article/list/search', 'ArticleController@search')->name('article.list.search');

Route::get('/article/edit/{id}', 'ArticleController@edit')->name('article.edit')->middleware('auth');

Route::post('/article/delete', 'ArticleController@delete')->name('article.delete')->middleware('auth');

Route::get('/user/index', 'UserController@index')->name('user.index');
