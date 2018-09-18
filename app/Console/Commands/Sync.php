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

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pascex:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(StatsService $statsService, PascalCoin $pascalCoin)
    {
        //\DB::table('blocks')->truncate();
        $latest = Block::orderBy('block', 'DESC')->first();
        $runningBlock = $pascalCoin->blocks()->count();
        $numOps = 0;
        $start = $latest !== null ? $latest->block - 5 : 0; // go 2 blocks back in history to check orphanced blocks
        for ($blockNo = $start; $blockNo < $runningBlock; $blockNo++) {
            if($blockNo % 100 === 0 && $blockNo > 0) {
                echo $blockNo . " (" . $numOps . ")\n";
            }
            $numOps += $statsService->syncBlock(new BlockNumber($blockNo));
            if($numOps > 20000 || $blockNo % 2000 === 0) {
                sleep(10);
                $numOps = 0;
            }
        }
    }
}
