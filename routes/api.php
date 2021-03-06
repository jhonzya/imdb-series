<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/title/search', 'TitleController@search')->name('search');
Route::get('/title/{title}/show', 'TitleController@show')->name('show');
Route::get('/episode/{episode}/show', 'TitleController@episode')->name('episode');
