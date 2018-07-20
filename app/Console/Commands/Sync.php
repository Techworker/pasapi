<?php

namespace App\Console\Commands;

use App\Block;
use App\RPC;
use App\Services\StatsService;
use Illuminate\Console\Command;
use Techworker\PascalCoin\PascalCoinRpcClient;
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
    public function handle(StatsService $statsService, PascalCoinRpcClient $rpc)
    {
        //\DB::table('blocks')->truncate();
        $latest = Block::orderBy('block', 'DESC')->first();
        $runningBlock = $rpc->getBlockCount();
        $numOps = 0;
        $start = $latest !== null ? $latest->block : 0;
        for ($blockNo = $start; $blockNo < $runningBlock; $blockNo++) {
            if($blockNo % 100 === 0) {
                echo $blockNo . " (" . $numOps . ")\n";
            }
            /*
            if($blockNo % 1000 === 0) {
                echo 'sleeping 20 seconds';
                sleep(20);
            }*/
            $numOps += $statsService->addNewBlock(new BlockNumber($blockNo));
            if($numOps > 20000 || $blockNo % 2000 === 0) {
                echo $blockNo . " (" . $numOps . ")\n";
                echo 'sleeping';
                sleep(10);
                $numOps = 0;
            }
        }

        /*
        $block = 0;
        do {
        } while();*/
    }
}
