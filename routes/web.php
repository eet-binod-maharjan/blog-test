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

Route::get('/{name}', 'UserController@show')->name('user.show');
Route::get('/books', 'BookController@index')->name('book.index');
Route::post('/books', 'BookController@store')->name('book.store');
Route::post('/books/{book}', 'BookController@update')->name('book.update');
Route::delete('/books/{book}','BookController@destroy')->name('book.destroy');

Route::resource('author', 'AuthorController');
