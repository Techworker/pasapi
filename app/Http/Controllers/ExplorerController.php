<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Techworker\PascalCoin\PascalCoinRpcClient;
use Techworker\PascalCoin\Type\Simple\BlockNumber;

class ExplorerController extends Controller
{
    public function blocks(Request $request, PascalCoinRpcClient $client)
    {
        $page = (int)$request->get('page', 1);
        $count = $client->getBlockCount();

        $prev = ['from' => $count - (($page - 1) * 10), 'to' => $count - (($page - 1) * 10) + 9];
        if ($page === 1) {
            $prev = null;
        }
        $next = ['from' => $count - (($page + 1) * 10), 'to' => $count - (($page + 1) * 10) + 9];
        if ($next['from'] < 0) {
            $next['from'] = 0;
        }
        if ($next['to'] < 0) {
            $next = null;
        }

        $s = $count - ($page * 10);
        $e = $count - ($page * 10) + 10 - 1;
        if ($s < 0) {
            $s = 1;
        }
        $blocks = $client->getBlocks(null, $s, $e);


        return view('explorer.blocks', [
            'blocks' => $blocks,
            'next' => $next,
            'prev' => $prev,
            'page' => $page
        ]);
    }

    public function blockDetail(int $block, PascalCoinRpcClient $client)
    {
        $count = $client->getBlockCount();
        if($block > $count - 1) {
            abort(404, 'Unknown block');
        }

        $block = $client->getBlock(new BlockNumber($block));
        return view('explorer.block', [
            'block' => $block
        ]);
    }
}
