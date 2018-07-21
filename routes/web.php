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

Route::get('/operations', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@operations'])->name('operations');
Route::get('/volume', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@volume'])->name('volume');
Route::get('/fees', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@fees'])->name('fees');
Route::get('/miners', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@miners'])->name('miners');
Route::get('/blocktime', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@blocktime'])->name('blocktime');
Route::get('/hashrate', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@hashrate'])->name('hashrate');
Route::get('/api', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@api'])->name('api');
Route::get('/foundation', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@foundation'])->name('foundation');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
