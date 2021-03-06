<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('', function(Request $request){
  return view('index', compact('request'));
})->name('index');

Route::prefix('rokusho')->as('rokusho.')->namespace('Rokusho')->group(function(){
  Route::get('', 'Controller@index')->name('simple');
  Route::post('', 'Controller@index');

  Route::get('new', 'Controller@newForm')->name('new');
  Route::post('new', 'Controller@startNew');

  Route::get('bid/{game_id}', 'Controller@bidForm')->name('bid');
  Route::post('bid/{game_id}', 'Controller@bidStore');

  Route::get('win/{game_id}', 'Controller@winForm')->name('win');
  Route::post('win/{game_id}', 'Controller@winStore');

  Route::get('{game_id}/current', 'Controller@current')->name('current');
  Route::get('{game_id}/log', 'Controller@log')->name('log');

  Route::get('language/{lang}', 'Controller@language')->name('language');
});
