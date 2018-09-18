<?php

namespace App\Console\Commands;

use App\Block;
use App\RPC;
use App\Services\StatsService;
use Illuminate\Console\Command;
use Techworker\PascalCoin\PascalCoin;
use Techworker\PascalCoin\PascalCoinRpcClient;
use Techworker\PascalCoin\Type\Account;
use Techworker\PascalCoin\Type\Simple\BlockNumber;

class SyncAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pascex:sync-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param StatsService $statsService
     * @param PascalCoin $pascalCoin
     * @throws \Techworker\PascalCoin\RPC\ConnectionException
     * @throws \Techworker\PascalCoin\RPC\ErrorException
     */
    public function handle(StatsService $statsService, PascalCoin $pascalCoin)
    {
        $richest = [];
        $runningBlock = $pascalCoin->blocks()->count();
        $step = 1000;
        for($account = 0; $account <= (($runningBlock - 1) * 5) - 1; $account += $step)
        {
            /** @var Account[] $accounts */
            $accounts = $pascalCoin->accounts()->paged($step, $account);
            foreach($accounts as $acc) {
                $richest[$acc->getAccount()] = (int)$acc->getBalance()->format(\Techworker\CryptoCurrency\Currencies\PascalCoin::MOLINA);
            }
            arsort($richest, SORT_NUMERIC);
            $richest = array_slice($richest, 0, 1000, true);

            echo $account . "\n";
            if($account % 100000 === 0) {
                sleep(10);
            }
        }

        $statsService->truncateAccounts();
        foreach($richest as $account => $balance) {
            $statsService->syncAccount(
                $pascalCoin->accounts()->find($account)
            );
        }
    }
}