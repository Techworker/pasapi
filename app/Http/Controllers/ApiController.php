<?php

namespace App\Http\Controllers;

use App\Block;
use App\Http\Resources\BlockCollection;
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
     * Gets the stats of all blocks.
     *
     * @return
     */
    public function statsHighestVolume()
    {
        $block = Block::orderBy('volume', 'DESC')->first();
        return new BlockResource($block);
    }

    /**
     * Gets the stats of all blocks.
     *
     * @return
     */
    public function statsHighestVolumeTop10()
    {
        $blocks = Block::orderBy('volume', 'DESC')->take(10)->get();
        return new BlockCollection($blocks);
    }

    /**
     * Gets the stats of all blocks.
     *
     * @return
     */
    public function statsHighestFee()
    {
        $block = Block::orderBy('fee', 'DESC')->first();
        return new BlockResource($block);
    }

    /**
     * Gets the stats of all blocks.
     *
     * @return
     */
    public function statsHighestFeeTop10()
    {
        $blocks = Block::orderBy('fee', 'DESC')->take(10)->get();
        return new BlockCollection($blocks);
    }

    /**
     * Gets the stats of all blocks.
     *
     * @return
     */
    public function statsHighestReward()
    {
        $block = Block::orderBy('reward', 'DESC')->first();
        return new BlockResource($block);
    }

    /**
     * Gets the stats of all blocks.
     *
     * @return
     */
    public function statsHighestRewardTop10()
    {
        $blocks = Block::orderBy('reward', 'DESC')->take(10)->get();
        return new BlockCollection($blocks);
    }

    /**
     * A small helper function to retrieve statistics.
     *
     * @param array $where
     * @return array
     */
    protected function getRawStats(array $where = [], $groupBy = [], $multi = false, $order = [])
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
        $raw[] = 'AVG(hashrate) AS avg_hashrate';

        if(count($groupBy) > 0) {
            $raw[] = $groupBy['expr'] . ' AS ' . $groupBy['alias'];
        }

        $query = \DB::table('blocks')
            ->selectRaw(implode(', ', $raw));
        foreach($where as $condition) {
            $query->where($condition[0], $condition[1], $condition[2]);
        }
        if(count($groupBy) > 0) {
            $query->groupBy($groupBy['alias']);
        }
        if(count($order) > 0) {
            $query->orderBy($order['field'], $order['order']);
        }

        $data = $query->get();
        $prepData = [];
        foreach($data as $entry)
        {
            $entry = collect($entry)->toArray();
            $fields = ['n_operations'];
            for($i = 0; $i <= 9; $i++) {
                $fields[] = 'n_type_' . $i;
            }

            foreach($fields as $field) {
                $entry['sum_' . $field] = (int)$entry['sum_' . $field];
                $entry['avg_' . $field] = round($entry['avg_' . $field], 2);
            }

            $entry['avg_hashrate'] = (string)round($entry['avg_hashrate']);

            $entry['sum_volume_molina'] = $entry['sum_volume'];
            $entry['sum_volume_pasc'] = PascalCurrency::fromMolinas($entry['sum_volume'])->getPascal();
            $entry['avg_volume_molina'] = (string)round($entry['avg_volume'], 0);
            $entry['avg_volume_pasc'] = PascalCurrency::fromMolinas(round($entry['avg_volume'], 0))->getPascal();
            unset($entry['sum_volume']);
            unset($entry['avg_volume']);
            $prepData[] = $entry;
        }

        if($multi) {
            return $prepData;
        }

        return $prepData[0];
    }

    /**
     * Gets data of the foundation accounts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    public function timelineDaily() {
        return response()->json(
            $this->getRawStats(
                [],
                ['expr' => "FROM_UNIXTIME(tstamp, '%Y-%m-%d')", 'alias' => 'day'],
                true,
                ['field' => 'day', 'order' => 'ASC']
            )
        );
    }
    public function timelineWeekly() {
        return response()->json(
            $this->getRawStats(
                [],
                ['expr' => "FROM_UNIXTIME(tstamp, '%Y-%U')", 'alias' => 'week'],
                true,
                ['field' => 'week', 'order' => 'ASC']
            )
        );
    }
    public function timelineMonthly() {
        return response()->json(
            $this->getRawStats(
                [],
                ['expr' => "FROM_UNIXTIME(tstamp, '%Y-%m')", 'alias' => 'month'],
                true,
                ['field' => 'month', 'order' => 'ASC']
            )
        );
    }
    public function timelineYearly() {
        return response()->json(
            $this->getRawStats(
                [],
                ['expr' => "FROM_UNIXTIME(tstamp, '%Y')", 'alias' => 'year'],
                true,
                ['field' => 'year', 'order' => 'ASC']
            )
        );
    }
}
