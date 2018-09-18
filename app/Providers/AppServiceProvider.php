<?php

namespace App\Providers;

use App\Account;
use App\Block;
use App\RPC;
use App\Services\StatsService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Graze\GuzzleHttp\JsonRpc\Client;
use Techworker\PascalCoin\EndPoint;
use Techworker\PascalCoin\FGuillot;
use Techworker\PascalCoin\PascalCoin;
use Techworker\PascalCoin\PascalCoinRpcClient;
use Techworker\PascalCoin\RawApi;
use Techworker\PascalCoin\RichApi;
use Techworker\PascalCoin\RPC\Curl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(!app()->runningInConsole()) {
            $latestBlock = Block::orderBy('block', 'DESC')->first();
            View::share('latest_block_no', $latestBlock->block);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PascalCoin::class, function() {
            $rpcClient = new Curl();
            $rawApiClient = new RawApi($rpcClient, new EndPoint('10.0.2.2'));
            return new PascalCoin(
                $rawApiClient,
                new RichApi\NodeApi($rawApiClient),
                new RichApi\WalletApi($rawApiClient),
                new RichApi\AccountApi($rawApiClient),
                new RichApi\BlockApi($rawApiClient)
            );
        });

        $this->app->singleton(StatsService::class, function($app) {
            return new StatsService($app->get(PascalCoin::class), new Block, new Account);
        });

    }
}