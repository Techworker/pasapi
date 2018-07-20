<?php

namespace App\Providers;

use App\Block;
use App\RPC;
use App\Services\StatsService;
use Illuminate\Support\ServiceProvider;

use Graze\GuzzleHttp\JsonRpc\Client;
use Techworker\PascalCoin\FGuillot;
use Techworker\PascalCoin\PascalCoinRpcClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PascalCoinRpcClient::class, function() {
            return new PascalCoinRpcClient(new FGuillot('http://localhost:4003'));
        });

        $this->app->singleton(StatsService::class, function($app) {
            return new StatsService($app->get(PascalCoinRpcClient::class), new Block);
        });
    }
}