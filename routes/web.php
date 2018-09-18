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

Route::get('/', function() {
    return redirect()->route('stats_operations');
});
Route::get('/operations', function() {
    return redirect()->route('stats_operations');
});

Route::get('/stats/richest', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@richest'])->name('stats_richest');
Route::get('/stats/operations', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@operations'])->name('stats_operations');
Route::get('/stats/volume', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@volume'])->name('stats_volume');
Route::get('/stats/fees', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@fees'])->name('stats_fees');
Route::get('/stats/miners', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@miners'])->name('stats_miners');
Route::get('/stats/blocktime', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@blocktime'])->name('stats_blocktime');
Route::get('/stats/hashrate', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@hashrate'])->name('stats_hashrate');
Route::get('/stats/apidoc', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@api'])->name('stats_api');
Route::get('/stats/foundation', ['middleware' => 'doNotCacheResponse', 'uses' => 'HomeController@foundation'])->name('stats_foundation');

Route::get('/explorer/blocks', ['middleware' => 'doNotCacheResponse', 'uses' => 'ExplorerController@blocks'])->name('explorer_blocks');
Route::get('/explorer/blocks/{block}', ['middleware' => 'doNotCacheResponse', 'uses' => 'ExplorerController@blockDetail'])->name('explorer_block_detail');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
