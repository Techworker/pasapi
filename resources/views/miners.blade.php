@extends('layouts.app')

@section('script')
    <script src="{{ asset('js/miners.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <h1>Miners</h1>
        <hr class="div"/>
        <p>This chart displays the number of mined blocks for nanopool, coinotron (2 biggest mining pools) and others. The data is taken from the blocks payload that is defined by each miner.</p>
        <nav class="nav nav-pills nav-justified" id="filter-optypes">
            <a class="nav-link" href="#" data-href="optypes-yearly">Yearly</a>
            <a class="nav-link" href="#" data-href="optypes-monthly">Monthly</a>
            <a class="nav-link" href="#" data-href="optypes-weekly">Weekly</a>
            <a class="nav-link" href="#" data-href="optypes-daily">Daily</a>
        </nav>
        <div class="row justify-content-center" id="chart-container">
            <div class="col-md-12">
                <div class="card mt--2" id="optypes-yearly">
                    <div class="card-header">Yearly miners</div>
                    <div class="chart">
                        <canvas id="yearly"></canvas>
                        @include('loading')
                    </div>
                    <table class="table table-striped table-responsive">
                        <thead>
                        <th>Year</th>
                        <th>Nanopool</th>
                        <th>Coinotron</th>
                        <th>Others</th>
                        </thead>
                    </table>
                </div>
                <div class="card mt--2" id="optypes-monthly">
                    <div class="card-header">Monthly miners</div>
                    <div class="chart">
                        <canvas id="monthly"></canvas>
                        @include('loading')
                        <table class="table table-striped table-responsive">
                            <thead>
                            <th>Month</th>
                            <th>Nanopool</th>
                            <th>Coinotron</th>
                            <th>Others</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card mt--2" id="optypes-weekly">
                    <div class="card-header">Weekly miners</div>
                    <div class="chart">
                        <canvas id="weekly"></canvas>
                        @include('loading')
                        <table class="table table-striped table-responsive">
                            <thead>
                            <th>Week</th>
                            <th>Nanopool</th>
                            <th>Coinotron</th>
                            <th>Others</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card mt--2" id="optypes-daily">
                    <div class="card-header">Daily miners</div>
                    <div class="chart">
                        <canvas id="daily"></canvas>
                        @include('loading')
                        <table class="table table-striped table-responsive">
                            <thead>
                            <th>Day</th>
                            <th>Nanopool</th>
                            <th>Coinotron</th>
                            <th>Others</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
