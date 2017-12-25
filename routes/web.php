<?php

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
