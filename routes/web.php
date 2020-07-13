<?php

use Illuminate\Support\Facades\Route;

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

Route::get('', 'Controller@index')->name('simple');
Route::post('', 'Controller@index');

Route::get('new', 'Controller@newForm')->name('new');
Route::post('new', 'Controller@startNew');

Route::get('master/{game_id}', 'Controller@form')->name('form');
Route::post('master/{game_id}', 'Controller@form');

Route::get('{game_id}/current', 'Controller@current')->name('current');
Route::get('{game_id}/log', 'Controller@log')->name('log');

Route::get('language/{lang}', 'Controller@language')->name('language');
