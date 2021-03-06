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

Route::group(['prefix' => 'birthday'], function(){

    Route::get('index', 'ApiTestController@index')->name('birthday.index');
    Route::get('create', 'ApiTestController@create')->name('birthday.create');
    Route::post('store', 'ApiTestController@store')->name('birthday.store');
    Route::get('show/{id}', 'ApiTestController@show')->name('birthday.show');
    Route::get('edit/{id}', 'ApiTestController@edit')->name('birthday.edit');
    Route::post('update/{id}', 'ApiTestController@update')->name('birthday.update');
    Route::post('destroy/{id}', 'ApiTestController@destroy')->name('birthday.destroy');

});
