<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $casts = [
        'data' => 'array',
    ];

    protected $fillable = [
        'account',
        'balance',
        'nops',
        'type',
        'name',
        'pk',
        'data'
    ];

    protected $primaryKey = 'account';
    public $incrementing = false;
}
