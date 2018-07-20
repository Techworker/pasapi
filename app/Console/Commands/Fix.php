<?php

namespace App\Console\Commands;

use App\Block;
use Illuminate\Console\Command;
use Techworker\PascalCoin\PascalCoinRpcClient;
use Techworker\PascalCoin\Type\Simple\BlockNumber;

class Fix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pascex:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(PascalCoinRpcClient $rpc)
    {
        $ct = 0;
        $size = 1;
        Block::orderBy('block', 'ASC')->where('hashrate', '=', 0)->where('block', '>', 0)->chunk($size, function ($blocks) use($rpc, &$ct, $size)
        {
            $blockNumbers = $blocks->pluck('block');
            $start = $blockNumbers[0];
            $end = $blockNumbers[count($blockNumbers)-1];
            if($start === 0) {
                $start = 1;
            }

            $remoteBlocks = $rpc->getBlocks(null, $start, $end);
            $remoteBlocksRef = [];
            foreach($remoteBlocks as $remoteBlock) {
                $remoteBlocksRef[$remoteBlock->getBlock()->getValue()] = $remoteBlock;
            }

            foreach ($blocks as $block) {
                if($block->block === 0) {
                    continue;
                }
                /** @var \Techworker\PascalCoin\Type\Block $remoteBlock */
                $remoteBlock = $remoteBlocksRef[$block->block];
                $block->hashrate = $remoteBlock->getHashRateKhs();
                $block->save();
            }
            $ct += $size;
            if($ct % 100 === 0) {
                echo $ct . "\n";
            }
        });
    }
}