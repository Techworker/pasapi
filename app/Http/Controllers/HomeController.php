<?php

namespace App\Http\Controllers;

use App\Block;
use Illuminate\Pagination\Paginator;
use Techworker\CryptoCurrency\Currencies\PascalCoin;
use Techworker\PascalCoin\Type\Simple\PascalCurrency;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function operations() {
        return view('operations');
    }
    public function volume() {
        return view('volume');
    }
    public function fees() {
        return view('fees');
    }
    public function miners() {
        return view('miners');
    }
    public function blocktime() {
        return view('blocktime');
    }
    public function hashrate() {
        return view('hashrate');
    }
    public function richest() {
        return view('richest');
    }
    public function api() {
        return view('api');
    }
    public function foundation() {
        $latestBlock = Block::orderBy('block', 'DESC')->first();
        return view('foundation', [
            'reference_block' => $latestBlock->block,
            'intro_block' => 210240,
            'n_accounts' => $latestBlock->block - 210240,
            'amount_molina' => (string)(new PascalCoin(($latestBlock->block - 210240) * 100000, PascalCoin::MOLINA))->format(PascalCoin::MOLINA),
            'amount_pasc' => (string)(new PascalCoin(($latestBlock->block - 210240) * 100000, PascalCoin::MOLINA))->format(PascalCoin::PASC),
        ]);
    }
}
