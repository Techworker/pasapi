@extends('layouts.app')

@section('script')
    <script src="{{ asset('js/misc.js') }}" defer></script>
@endsection

<?php /** @var $block \Techworker\PascalCoin\Type\Block */ ?>
@section('content')
    <div class="container">
        <h1>Block {{$block->getBlock()}}</h1>
        <hr class="div"/>
        <p></p>
        <div class="row">
            <div class="col-md-6">
                <div class="key-infos card mt--2">
                    <div class="card-header">
                        Key Information
                    </div>
                    <div class="p-2 info">
                        <div class="value">
                            <label class="value-label">Block number:</label>
                            <div class="value-value">{{$block->getBlock()}}</div>
                        </div>
                        <div class="value">
                            <label class="value-label">Time:</label>
                            <div class="value-value">{{\Carbon\Carbon::createFromTimestampUTC($block->getTimestamp())->toAtomString() }}</div>
                        </div>
                        <div class="value">
                            <label class="value-label">Number of operations:</label>
                            <div class="value-value">{{$block->getNumberOfOperations() }}</div>
                        </div>
                        <div class="value">
                            <label class="value-label">Fee:</label>
                            <div class="value-value">{{$block->getFee()->format(\Techworker\CryptoCurrency\Currencies\PascalCoin::PASC) }} PASC</div>
                        </div>
                        <div class="value">
                            <label class="value-label">Volume:</label>
                            <div class="value-value">{{$dbBlock->volume}}</div>
                        </div>
                        <div class="value">
                            <label class="value-label">Accounts:</label>
                            <div class="value-value">
                                @foreach($block->getAccounts() as $account)
                                    <a href="#">{{$account}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card mt--2">
                    <div class="card-header">
                        blockchain
                    </div>
                    <div class="p-2 info">
                        <div class="value">
                            <label class="value-label">Version:</label>
                            <div class="value-value">{{$block->getVer()}}</div>
                        </div>
                        <div class="value">
                            <label class="value-label">Operation Hash:</label>
                            <div class="value-value">{{$block->getOphash()->getValue()}}</div>
                        </div>
                        <div class="value">
                            <label class="value-label">SafeBox Hash:</label>
                            <div class="value-value">{{$block->getSbh()->getValue()}}</div>
                        </div>
                        <div class="value">
                            <label class="value-label">Target:</label>
                            <div class="value-value">{{$block->getTarget()}}</div>
                        </div>
                        <div class="value">
                            <label class="value-label">Nonce:</label>
                            <div class="value-value">{{$block->getNonce()}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt--2">
                    <div class="card-header">
                        mining
                    </div>
                    <div class="p-2 info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="value">
                                    <label class="value-label">Public Key:</label>
                                    <div class="value-value">{{$block->getEncPubKey()->getValue()}}</div>
                                </div>
                                <div class="value">
                                    <label class="value-label">Payload:</label>
                                    <div class="value-value">{{$block->getPayload()}}</div>
                                </div>
                                <div class="value">
                                    <label class="value-label">Hashrate:</label>
                                    <div class="value-value">{{$block->getHashRateKhs()}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="value">
                                    <label class="value-label">Reward:</label>
                                    <div class="value-value">{{$block->getReward()->format(\Techworker\CryptoCurrency\Currencies\PascalCoin::PASC)}} PASC</div>
                                </div>
                                <div class="value">
                                    <label class="value-label">Proof of Work:</label>
                                    <div class="value-value">{{$block->getPow()}}</div>
                                </div>
                                <div class="value">
                                    <label class="value-label">Protocol:</label>
                                    <div class="value-value">{{$block->getVerA()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mt--2">
                <div class="card-header">
                    Operations
                </div>
                <div class="p-2 info">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <th>#</th>
                                    <th>Text</th>
                                    <th>Operation Type</th>
                                    <th>Account</th>
                                    <th>Volume</th>
                                    <th>Fee</th>
                                    </thead>
                                    <tbody>
                                    <?php /** @var $operation \Techworker\PascalCoin\Type\Operation */ ?>
                                    @foreach($operations as $operation)
                                        <tr>
                                            <td><a href="#">{{$operation->getOpBlock()}}/{{$operation->getBlock()->getValue()}}</a></td>
                                            <td>{{$operation->getOpTxt()}}</td>
                                            <td>@include('macros.op_type', ['opType' => $operation->getOpType()]) (type {{$operation->getOpType()}})</td>
                                            <td>@include('macros.account_number', ['account' => $operation->getAccount()])</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection