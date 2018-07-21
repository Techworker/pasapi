@extends('layouts.app')

@section('script')
    <script src="{{ asset('js/misc.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <h1>Foundation</h1>
        <hr class="div"/>
        <p>With <a href="https://www.pascalcoin.org/development/pips/pip-10">PIP-10</a> and <a href="https://www.pascalcoin.org/development/pips/pip-11">PIP-11</a> active after block 210240, a central public key currently owned by a trustable PascalCoin developer will get 1 account and 10.0000 PASC with each block. With these funds available, the PascalCoin project will be able to achieve it's longterm goals and support further development, marketing and other cost-intensive resources.</p>
        <h2>Current stats</h2>
        <p>Blocks since 210240: <b>{{$reference_block - $intro_block}}</b></p>
        <p>Accounts owned by the foundation: <b>{{$n_accounts}}</b></p>
        <p>PASC owned by the foundation: <b>{{$amount_pasc}} PSC</b></p>
    </div>

@endsection
