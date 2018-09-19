@extends('layouts.app')

@section('script')
    <script src="{{ asset('js/misc.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <h1>Blocks</h1>
        <hr class="div"/>
        <p>You are looking at blocks {{$start}} to {{$end}} in descending order. </p>
        <div class="card mt--2" id="optypes-monthly">
            <div class="card-header">
                @if($prev !== null)
                <a href="{{route('explorer_blocks', ['page' => $page - 1])}}" class="btn btn-info"><i class="fas fa-chevron-left"></i> Blocks {{$prev['from']}} to {{$prev['to']}}</a>
                @endif
                @if($next !== null)
                <a href="{{route('explorer_blocks', ['page' => $page + 1])}}" class="btn btn-info fa-pull-right"> Blocks {{$next['from']}} to {{$next['to']}} <i class="fas fa-chevron-right pull-right"></i></a>
                @endif
            </div>
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <th>#</th>
            <th>Time</th>
            <th>Operations</th>
            <th>Payload</th>
            <th>Volume</th>
            <th>Fee</th>
            </thead>
            <tbody>
                <?php /** @var $block \Techworker\PascalCoin\Type\Block */ ?>
                @foreach($blocks as $block)
                <tr>
                    <td>@include('macros.block_number', ['block' => $block->getBlock()])</td>
                    <td>{{\Carbon\Carbon::createFromTimestampUTC($block->getTimestamp())->toAtomString()}}</td>
                    <td>{{$block->getNumberOfOperations()}}</td>
                    <td>{{$block->getPayload()}}</td>
                    <td>{{$additional[$block->getBlock()]['volume']->format(\Techworker\CryptoCurrency\Currencies\PascalCoin::PASC)}}</td>
                    <td>{{$block->getFee()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        </div>
        </div>
    </div>
@endsection