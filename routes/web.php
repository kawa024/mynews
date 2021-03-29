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

Route::group(['prefix' => 'admin'], function() {
    Route::get('profile/create', 'Admin\ProfileController@add')->middleware('auth');
    Route::get('profile/edit', 'Admin\ProfileController@edit')->middleware('auth');
});
Auth::routes();




Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function()
    {
     Route::get('news/create', 'Admin\NewsController@add');
     Route::post('news/create', 'Admin\NewsController@create'); # 追記
     //テキストphp/laravel13 課題の3
     Route::post('profile/create', 'Admin\ProfileController@create');
     //テキストphp/laravel13 課題の6
     Route::post('profile/edit', 'Admin\ProfileController@update');
     
     Route::get('profile/edit', 'Admin\ProfileController@edit');
     Route::get('profile', 'Admin\ProfileController@index');
     Route::get('profile/delete', 'Admin\ProfileController@delete');
     
     Route::get('news', 'Admin\NewsController@index');
     
     Route::get('news/edit', 'Admin\NewsController@edit');
     
     Route::post('news/edit', 'Admin\NewsController@update');
     
     Route::get('news/delete', 'Admin\NewsController@delete');
    });
    
    Route::get('/', 'NewsController@index');
    //phplaravel19課題
    Route::get('/profile', 'ProfileController@index');




