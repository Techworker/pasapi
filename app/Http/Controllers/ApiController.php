<?php

namespace App\Http\Controllers;

use App\Account;
use App\Block;
use App\Http\Resources\BlockCollection;
use App\Http\Resources\Index as IndexResource;
use App\Http\Resources\Block as BlockResource;
use Techworker\CryptoCurrency\Currencies\PascalCoin as PascalCoinCurrency;
use Techworker\PascalCoin\Type\Simple\AccountNumber;

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
     * A small helper function to retrieve statistics.
     *
     * @param array $where
     * @return array
     */
    protected function getRawStats(array $where = [], $groupBy = [], $multi = false, $order = [])
    {
        $fields = ['volume', 'fee', 'duration', 'hashrate', 'n_operations_single' => 'n_operations'];
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
            $entry['sum_volume_pasc'] = (new PascalCoinCurrency($entry['sum_volume'], PascalCoinCurrency::MOLINA))->format(PascalCoinCurrency::PASC);
            $entry['avg_volume_molina'] = (string)round($entry['avg_volume'], 0);
            $entry['avg_volume_pasc'] = (new PascalCoinCurrency($entry['avg_volume'], PascalCoinCurrency::MOLINA))->format(PascalCoinCurrency::PASC);
            unset($entry['sum_volume']);
            unset($entry['avg_volume']);

            $entry['sum_fee_molina'] = $entry['sum_fee'];
            $entry['sum_fee_pasc'] = (new PascalCoinCurrency($entry['sum_fee'], PascalCoinCurrency::MOLINA))->format(PascalCoinCurrency::PASC);
            $entry['avg_fee_molina'] = (string)round($entry['avg_fee'], 0);
            $entry['avg_fee_pasc'] = (new PascalCoinCurrency($entry['avg_fee'], PascalCoinCurrency::MOLINA))->format(PascalCoinCurrency::PASC);
            unset($entry['sum_fee']);
            unset($entry['avg_fee']);
            $prepData[] = $entry;
        }

        if($multi) {
            return $prepData;
        }

        return $prepData[0];
    }

    /**
     * A small helper function to retrieve statistics.
     *
     * @param array $where
     * @return array
     */
    protected function getMinerStats($groupBy = [], $order = [])
    {
        $query = \DB::table('blocks');

        $raw = [];
        $raw[] = 'COUNT(*) as ct';
        $raw[] = 'SUBSTRING(payload, 1, 8) AS pl';
        $raw[] = $groupBy['expr'] . ' AS ' . $groupBy['alias'];
        $query->selectRaw(implode(', ', $raw));
        $query->groupBy($groupBy['alias']);
        $query->groupBy('pl');
        $query->orderBy($order['field'], $order['order']);

        $data = $query->get();
        $prepData = [];
        foreach($data as $entry)
        {
            $entry = collect($entry)->toArray();
            $prepData[] = $entry;
        }

        $grouped = collect($prepData)->groupBy($groupBy['alias']);
        $result = [];
        foreach($grouped as $gp => $miners) {
            $coinotron = $nanopool = $others = 0;
            foreach($miners as $miner) {
                if(substr($miner['pl'], 0, 8) === 'Nanopool') {
                    $nanopool += (int)$miner['ct'];
                } else if(substr($miner['pl'], 0, 8) === 'coinotro') {
                    $coinotron += (int)$miner['ct'];
                } else {
                    $others += (int)$miner['ct'];
                }
            }

            $result[] = [
                $groupBy['alias'] => $gp,
                'ct' => $nanopool,
                'type' => 'nanopool'
            ];
            $result[] = [
                $groupBy['alias'] => $gp,
                'ct' => $coinotron,
                'type' => 'coinotron'
            ];
            $result[] = [
                $groupBy['alias'] => $gp,
                'ct' => $others,
                'type' => 'others'
            ];
        }

        return $result;
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

    public function minersDaily() {
        return response()->json($this->getMinerStats(
            ['expr' => "FROM_UNIXTIME(tstamp, '%Y-%m-%d')", 'alias' => 'day'],
            ['field' => 'day', 'order' => 'ASC']
        ));
    }

    public function minersWeekly() {
        return response()->json($this->getMinerStats(
            ['expr' => "FROM_UNIXTIME(tstamp, '%Y-%U')", 'alias' => 'week'],
            ['field' => 'week', 'order' => 'ASC']
        ));
    }

    public function minersMonthly() {
        return response()->json($this->getMinerStats(
            ['expr' => "FROM_UNIXTIME(tstamp, '%Y-%m')", 'alias' => 'month'],
            ['field' => 'month', 'order' => 'ASC']
        ));
    }

    public function minersYearly() {
        return response()->json($this->getMinerStats(
            ['expr' => "FROM_UNIXTIME(tstamp, '%Y')", 'alias' => 'year'],
            ['field' => 'year', 'order' => 'ASC']
        ));
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
    public function timelineHourly() {
        return response()->json(
            $this->getRawStats(
                [['tstamp', '>=', time() - (24*60*60*7)]],
                ['expr' => "FROM_UNIXTIME(tstamp, '%Y-%m-%d %H:00:00')", 'alias' => 'hour'],
                true,
                ['field' => 'hour', 'order' => 'ASC']
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

    public function richest() {
        $accounts = Account::orderBy('balance', 'DESC')->take(500)->get()->toArray();
        $jsonAccounts = [];
        $block = Block::orderBy('block', 'DESC')->first();
        $pascAvailable = (new PascalCoinCurrency((210240 * 100) + (($block->block - 210240) * 50)))->format(PascalCoinCurrency::MOLINA);
        foreach($accounts as $account) {

            $jsonAccounts[] = [
                'account' => (new AccountNumber($account['account']))->__toString(),
                'balance_molina_' => (string)$account['balance'],
                'balance_pasc' => (new PascalCoinCurrency($account['balance'], PascalCoinCurrency::MOLINA))->format(PascalCoinCurrency::PASC),
                'percent' => round($account['balance'] * 100 / $pascAvailable, 2),
                'type' => $account['type'],
                'name' => $account['name'],
                'nops' => $account['nops']
            ];
        }
        return response()->json($jsonAccounts);
    }
}
