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

Route::get('/', 'TodoController@index' );
Route::get('/childes/{parentId}', 'ChildTodoController@index' );

Route::post('/todo/uploadFile', 'TodoController@uploadFile')->name('todo.uploadFile');
Route::post('/todo/downloadFile', 'TodoController@downloadFile')->name('todo.downloadFile');


Route::resource('todo', "TodoController");
Route::resource('childTodo', "ChildTodoController");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
