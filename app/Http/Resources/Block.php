<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Techworker\PascalCoin\Type\Simple\PascalCurrency;

class Block extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Block $block */
        $block = $this->resource;

        return [
            'block' => $block->block,
            'timestamp' => $block->tstamp,
            'utc' => Carbon::createFromTimestampUTC($block->tstamp)->toIso8601String(),
            'enc_pubkey' => $block->enc_pubkey,
            'reward' => $block->reward,
            'reward_pasc' => PascalCurrency::fromMolinas($block->reward)->getPascal(),
            'fee' => $block->fee,
            'fee_pasc' => PascalCurrency::fromMolinas($block->fee)->getPascal(),
            'ver' => $block->ver,
            'payload' => $block->payload,
            'n_type_0' => $block->n_type_0,
            'n_type_1' => $block->n_type_1,
            'n_type_2' => $block->n_type_2,
            'n_type_3' => $block->n_type_3,
            'n_type_4' => $block->n_type_4,
            'n_type_5' => $block->n_type_5,
            'n_type_6' => $block->n_type_6,
            'n_type_7' => $block->n_type_7,
            'n_type_8' => $block->n_type_8,
            'n_type_9' => $block->n_type_9,
            'n_uniq_receivers' => $block->n_uniq_receivers,
            'n_uniq_changers' => $block->n_uniq_changers,
            'n_uniq_senders' => $block->n_uniq_senders,
            'n_uniq_accounts' => $block->n_uniq_accounts,
            'n_operations_single' => $block->n_operations_single,
            'n_operations_multi' => $block->n_operations_multi,
            'volume' => (string)$block->volume,
            'volume_pasc' => PascalCurrency::fromMolinas($block->volume)->getPascal(),
            'duration' => $block->duration
        ];
        //print_r($request);
    }
}
