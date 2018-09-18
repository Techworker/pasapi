<?php

namespace App\Services;

use App\Account;
use App\Block;
use Spatie\ResponseCache\Facades\ResponseCache;
use Techworker\PascalCoin\PascalCoin;
use Techworker\PascalCoin\PascalCoinRpcClient;
use Techworker\PascalCoin\Type\Operation;
use Techworker\PascalCoin\Type\Simple\BlockNumber;

class StatsService
{

    /**
     * @var Block
     */
    protected $blockModel;

    /**
     * @var Account
     */
    protected $accountModel;

    /**
     * @var PascalCoin
     */
    protected $pascal;

    public function __construct(PascalCoin $pascal, Block $blockModel, Account $accountModel)
    {
        $this->pascal = $pascal;
        $this->blockModel = $blockModel;
        $this->accountModel = $accountModel;
    }

    public function syncBlock(BlockNumber $blockNo)
    {
        /** @var Block $dbPreviousBlock */
        $dbPreviousBlock = Block::whereBlock($blockNo->getValue() - 1)->first();

        $remoteBlock = $this->pascal->blocks()->at($blockNo);
        if($remoteBlock === null) {
            return;
        }

        /** @var Operation[] $allOps */
        $allOps = $this->pascal->blocks()->allOperations($blockNo);

        $blockData = [
            'block' => $remoteBlock->getBlock(),
            'enc_pubkey' => $remoteBlock->getEncPubKey()->getValue(),
            'reward' => $remoteBlock->getReward()->format(\Techworker\CryptoCurrency\Currencies\PascalCoin::MOLINA),
            'fee' => $remoteBlock->getFee()->format(\Techworker\CryptoCurrency\Currencies\PascalCoin::MOLINA),
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
                $volume += (int)$receiver->getAmount()->format(\Techworker\CryptoCurrency\Currencies\PascalCoin::MOLINA);
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

        /** @var Block $dbBlock */
        $dbBlock = Block::firstOrNew(['block' => $blockNo->getValue()], $blockData);
        $dbBlock->save();

        ResponseCache::clear();
        $routeCollection = \Route::getRoutes();
        foreach ($routeCollection as $value) {
            if(!$value->getName()) {
                continue;
            }

            if(substr($value->getName(), 0, 4) === 'api_') {
                try {
                    file_get_contents(route($value->getName()));
                } catch (\Exception $ex) {

                }
            }
        }

        return count($allOps);
    }

    public function syncAccount(\Techworker\PascalCoin\Type\Account $account)
    {
        $dbAccount = Account::firstOrNew([
            'account' => $account->getAccount()
        ], [
            'balance' => $account->getBalance()->format(\Techworker\CryptoCurrency\Currencies\PascalCoin::MOLINA),
            'nops' => $account->getNOperation(),
            'data' => $account->getRaw(),
            'type' => $account->getType(),
            'name' => $account->getName(),
            'pk' => $account->getEncPubKey()->getValue()
        ]);
        $dbAccount->save();
    }

    public function truncateAccounts() {
        Account::truncate();
    }
}