<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', 'ApiController@index')->name('api_index');
Route::get('/blocks/latest', 'ApiController@blocksLatest')->name('api_blocks_latest');
Route::get('/blocks/{blockNumber}', 'ApiController@blocksDetail')->name('api_blocks_detail');

Route::get('/timeline/daily', 'ApiController@timelineDaily')->name('api_timeline_daily');
Route::get('/timeline/weekly', 'ApiController@timelineWeekly')->name('api_timeline_weekly');
Route::get('/timeline/monthly', 'ApiController@timelineMonthly')->name('api_timeline_monthly');
Route::get('/timeline/yearly', 'ApiController@timelineYearly')->name('api_timeline_yearly');

Route::get('/stats', 'ApiController@stats')->name('api_stats');
Route::get('/stats/24', 'ApiController@stats24')->name('api_stats_24');
Route::get('/stats/highest/volume', 'ApiController@statsHighestVolume')->name('api_stats_highest_volume');
Route::get('/stats/highest/volume/top10', 'ApiController@statsHighestVolumeTop10')->name('api_stats_highest_volume_top10');
Route::get('/stats/highest/fee', 'ApiController@statsHighestFee')->name('api_stats_highest_fee');
Route::get('/stats/highest/fee/top10', 'ApiController@statsHighestFeeTop10')->name('api_stats_highest_fee_top10');
Route::get('/stats/highest/reward', 'ApiController@statsHighestReward')->name('api_stats_highest_reward');
Route::get('/stats/highest/reward/top10', 'ApiController@statsHighestRewardTop10')->name('api_stats_highest_reward_top10');


Route::get('/ops/24', 'ApiController@ops24');
Route::get('/highest_volume', 'ApiController@highestVolume');
Route::get('/highest_volume/top/10', 'ApiController@highestVolumeTop10');
Route::get('/highest_fee', 'ApiController@highestFee');
Route::get('/highest_reward', 'ApiController@highestReward');
Route::get('/ops/{blockFrom}/{blockTo}', 'ApiController@opsFromToBlock');

Route::get('/foundation', 'ApiController@foundation');