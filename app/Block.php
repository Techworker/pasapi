<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'block',
        'enc_pubkey',
        'reward',
        'fee',
        'ver',
        'tstamp',
        'payload',
        'n_operations_single',
        'n_operations_multi',
        'volume',
        'duration',
        'n_uniq_senders',
        'n_uniq_receivers',
        'n_uniq_changers',
        'n_uniq_accounts',
        'n_type_0',
        'n_type_1',
        'n_type_2',
        'n_type_3',
        'n_type_4',
        'n_type_5',
        'n_type_6',
        'n_type_7',
        'n_type_8',
        'n_type_9',
        'hashrate'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}