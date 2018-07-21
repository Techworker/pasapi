<?php

namespace App\Services;

use App\Block;
use Spatie\ResponseCache\Facades\ResponseCache;
use Techworker\PascalCoin\PascalCoinRpcClient;
use Techworker\PascalCoin\Type\Simple\BlockNumber;

class StatsService
{

    /**
     * @var Block
     */
    protected $blockModel;

    /**
     * @var PascalCoinRpcClient
     */
    protected $rpc;

    public function __construct(PascalCoinRpcClient $rpc, Block $blockModel)
    {
        $this->rpc = $rpc;
        $this->blockModel = $blockModel;
    }

    public function addNewBlock(BlockNumber $blockNo)
    {
        /** @var Block $dbBlock */
        $dbBlock = Block::whereBlock($blockNo->getValue())->first();
        if($dbBlock !== null) {
            return;
        }

        /** @var Block $dbPreviousBlock */
        $dbPreviousBlock = Block::whereBlock($blockNo->getValue() - 1)->first();

        $remoteBlock = $this->rpc->getBlock($blockNo);
        if($remoteBlock === null) {
            return;
        }

        $allOps = $this->rpc->getAllBlockOperations($blockNo, 100);

        $blockData = [
            'block' => $remoteBlock->getBlock()->getValue(),
            'enc_pubkey' => $remoteBlock->getEncPubKey()->getValue(),
            'reward' => $remoteBlock->getReward()->getMolinas(),
            'fee' => $remoteBlock->getFee()->getMolinas(),
            'ver' => $remoteBlock->getVer(),
            'tstamp' => $remoteBlock->getTimestamp(),
            'hashrate' => $remoteBlock->getHashRateKhs(),
            'payload' => $remoteBlock->getPayload(),
            'duration' => $dbPreviousBlock !== null ? $remoteBlock->getTimestamp() - $dbPreviousBlock->tstamp : 0,
        ];

        for($i = 0; $i <= 9; $i++) {
            $blockData['n_type_' . $i] = 0;
        }
        $senderAccounts = [];
        $receiverAccounts = [];
        $changerAccounts = [];
        $allAccounts = [];
        $volume = 0;

        foreach($allOps as $op)
        {
            if($op->getAccount() !== null) {
                $allAccounts[] = $op->getAccount()->getAccount();
            }
            if($op->getSignerAccount() !== null) {
                $allAccounts[] = $op->getSignerAccount()->getAccount();
            }

            $blockData['n_type_'. $op->getOpType()]++;
            foreach($op->getReceivers() as $idx => $receiver) {
                // exclude fee
                $volume += (int)$receiver->getAmount()->getMolinas();
                $receiverAccounts[] = $receiver->getAccount()->getAccount();
            }
            foreach($op->getSenders() as $idx => $sender) {
                $senderAccounts[] = $sender->getAccount()->getAccount();
            }
            foreach($op->getChangers() as $idx => $changer) {
                // exclude fee
                $changerAccounts[] = $changer->getAccount()->getAccount();
                if($changer->getSellerAccount() !== null) {
                    $changerAccounts[] = $changer->getSellerAccount()->getAccount();
                }
            }
        }

        $blockData['n_uniq_receivers'] = count(array_filter(array_unique($receiverAccounts)));
        $blockData['n_uniq_changers'] = count(array_filter(array_unique($changerAccounts)));
        $blockData['n_uniq_senders'] = count(array_filter(array_unique($senderAccounts)));
        $blockData['n_uniq_accounts'] = count(array_filter(array_unique(array_merge($allAccounts, $receiverAccounts, $changerAccounts, $senderAccounts))));
        $blockData['n_operations_single'] = count($allOps); // TODO
        $blockData['n_operations_multi'] = count($allOps); // TODO
        $blockData['volume'] = $volume;
        $block = new Block($blockData);
        $block->save();

        ResponseCache::clear();
        $routeCollection = \Route::getRoutes();
        foreach ($routeCollection as $value) {
            if(!$value->getName()) {
                continue;
            }

            if(substr($value->getName(), 0, 4) === 'api_') {
                try {
                    file-get_contents(route($value->getName()));
                } catch (\Exception $ex) {

                }
            }
        }

        return count($allOps);
    }

}