<?php

namespace App\Console\Commands;

use App\Block;
use App\RPC;
use Graze\GuzzleHttp\JsonRpc\Client;
use Graze\GuzzleHttp\JsonRpc\Exception\RequestException;
use Illuminate\Console\Command;

class Poll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
    public function handle(RPC $rpc)
    {
        $lastBlock = Block::orderBy('id', 'desc')->first();
        $runningBlock = $rpc->execute('getblockcount');

        echo $lastRemoteBlock;
        exit;
        exit;

    }
}
