<?php

namespace App\Http\Controllers;

use App\Block;
use App\Http\Resources\Index as IndexResource;
use App\Http\Resources\Block as BlockResource;
use Illuminate\Http\Request;
use Techworker\PascalCoin\Type\Simple\PascalCurrency;

class ApiController extends Controller
{
    /**
     * Shows the index page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return new IndexResource([]);
    }

    /**
     * Gets the latest block.
     *
     * @return \App\Http\Resources\Block
     */
    public function blocksLatest()
    {
        $block = Block::orderBy('block', 'DESC')->first();
        return new BlockResource($block);
    }

    /**
     * Gets the latest block.
     *
     * @return \App\Http\Resources\Block
     */
    public function blocksDetail(int $blockNumber)
    {
        $block = Block::whereBlock($blockNumber)->first();
        return new BlockResource($block);
    }

    /**
     * Gets the stats of all blocks.
     *
     * @return
     */
    public function stats()
    {
        return response()->json($this->getRawStats());
    }

    /**
     * Gets the stats of all blocks.
     *
     * @return
     */
    public function stats24()
    {
        $data = $this->getRawStats([
            ['tstamp', '>=', time() - (24*60*60)]
        ]);
        $data['block_latest'] = Block::orderBy('block', 'DESC')->first()->block;
        $data['block_earliest'] = Block::orderBy('block', 'ASC')
            ->where('tstamp', '>=', time() - (24*60*60))
            ->first()
            ->block;

        return response()->json($data);
    }

    /**
     * A small helper function to retrieve statistics.
     *
     * @param array $where
     * @return array
     */
    protected function getRawStats(array $where = [])
    {
        $fields = ['volume', 'n_operations_single' => 'n_operations'];
        for($i = 0; $i <= 9; $i++) {
            $fields[] = 'n_type_' . $i;
        }

        $raw = [];
        foreach($fields as $field => $alias) {
            if(is_int($field)) {
                $field = $alias;
            }
            $raw[] = 'SUM(' . $field . ') AS sum_' . $alias;
            $raw[] = 'AVG(' . $field . ') AS avg_' . $alias;
        }

        $query = \DB::table('blocks')
            ->selectRaw(implode(', ', $raw));
        foreach($where as $condition) {
            $query->where($condition[0], $condition[1], $condition[2]);
        }
        $statsDb = $query->first();

        $stats = collect($statsDb)->toArray();

        $fields = ['n_operations'];
        for($i = 0; $i <= 9; $i++) {
            $fields[] = 'n_type_' . $i;
        }

        foreach($fields as $field) {
            $stats['sum_' . $field] = (int)$stats['sum_' . $field];
            $stats['avg_' . $field] = round($stats['avg_' . $field], 2);
        }

        $stats['sum_volume_molina'] = $stats['sum_volume'];
        $stats['sum_volume_pasc'] = PascalCurrency::fromMolinas($stats['sum_volume'])->getPascal();
        $stats['avg_volume_molina'] = (string)round($stats['avg_volume'], 0);
        $stats['avg_volume_pasc'] = PascalCurrency::fromMolinas(round($stats['avg_volume'], 0))->getPascal();
        unset($stats['sum_volume']);
        unset($stats['avg_volume']);

        return $stats;
    }

    public function foundation() {

        $latestBlock = Block::orderBy('block', 'DESC')->first();
        return response()->json([
            'reference_block' => $latestBlock->block,
            'intro_block' => 210240,
            'n_accounts' => $latestBlock->block - 210240,
            'amount_molina' => (string)PascalCurrency::fromMolinas(($latestBlock->block - 210240) * 100000)->getMolinas(),
            'amount_pasc' => (string)PascalCurrency::fromMolinas(($latestBlock->block - 210240) * 100000)->getPascal()
        ]);
    }
}
