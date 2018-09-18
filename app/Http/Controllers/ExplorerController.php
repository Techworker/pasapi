<?php

namespace App\Http\Controllers;

use App\Block;
use Illuminate\Http\Request;
use Techworker\PascalCoin\PascalCoin;
use Techworker\PascalCoin\Type\Simple\BlockNumber;
use Techworker\CryptoCurrency\Currencies\PascalCoin as PascalCoinCurrency;

class ExplorerController extends Controller
{
    public function blocks(Request $request, PascalCoin $client)
    {
        $page = (int)$request->get('page', 1);
        $count = \App\Block::count();

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

        $start = $count - ($page * 10);
        $end = $count - ($page * 10) + 10 - 1;
        if ($start < 0) {
            $start = 1;
        }

        /** @var \Techworker\PascalCoin\Type\Block[] $blocks */
        $blocks = $client->blocks()->paged($start, $end);
        $additional = [];
        foreach($blocks as $block) {
            /** @var Block $dbBlock */
            $dbBlock = Block::whereBlock($block->getBlock())->first();

            $additional[$block->getBlock()] = [
                'volume' => new PascalCoinCurrency($dbBlock->volume, PascalCoinCurrency::MOLINA)
            ];
        }

        return view('explorer.blocks', [
            'blocks' => $blocks,
            'additional' => $additional,
            'next' => $next,
            'prev' => $prev,
            'page' => $page,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function blockDetail(int $block, PascalCoin $client)
    {
        $count = \App\Block::count();
        if($block > $count - 1) {
            abort(404, 'Unknown block');
        }

        $block = $client->blocks()->at($block);
        return view('explorer.block', [
            'block' => $block
        ]);
    }

}
