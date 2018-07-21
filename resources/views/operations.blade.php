@extends('layouts.app')

@section('script')
    <script src="{{ asset('js/operations.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <h1>Operations Types</h1>
        <hr class="div"/>
        <p>PascalCoin distinguishes between 10 different operation types (<a href="#" onclick="" data-toggle="modal" data-target="#exampleModal">more...</a>). These charts provide data about the different operation types in different timespans.</p>

        <nav class="nav nav-pills nav-justified" id="filter-optypes">
            <a class="nav-link" href="#" data-href="optypes-yearly">Yearly</a>
            <a class="nav-link" href="#" data-href="optypes-monthly">Monthly</a>
            <a class="nav-link" href="#" data-href="optypes-weekly">Weekly</a>
            <a class="nav-link" href="#" data-href="optypes-daily">Daily</a>
        </nav>
        <div class="row justify-content-center" id="chart-container">
            <div class="col-md-12">
                <div class="card mt--2" id="optypes-yearly">
                    <div class="card-header">Yearly operations</div>
                    <div class="chart">
                        <canvas id="types_yearly"></canvas>
                        @include('loading')
                    </div>
                    <table class="table table-striped table-responsive">
                        <thead>
                        <th>Year</th>
                        <th>All</th>
                        <th>Type 0</th>
                        <th>Type 1</th>
                        <th>Type 2</th>
                        <th>Type 3</th>
                        <th>Type 4</th>
                        <th>Type 5</th>
                        <th>Type 6</th>
                        <th>Type 7</th>
                        <th>Type 8</th>
                        <th>Type 9</th>
                        </thead>
                    </table>
                </div>
                <div class="card mt--2" id="optypes-monthly">
                    <div class="card-header">Monthly operations</div>
                    <div class="chart">
                        <canvas id="monthly"></canvas>
                        @include('loading')
                        <table class="table table-striped table-responsive">
                            <thead>
                            <th>Month</th>
                            <th>All</th>
                            <th>Type 0</th>
                            <th>Type 1</th>
                            <th>Type 2</th>
                            <th>Type 3</th>
                            <th>Type 4</th>
                            <th>Type 5</th>
                            <th>Type 6</th>
                            <th>Type 7</th>
                            <th>Type 8</th>
                            <th>Type 9</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card mt--2" id="optypes-weekly">
                    <div class="card-header">Weekly operations</div>
                    <div class="chart">
                        <canvas id="weekly"></canvas>
                        @include('loading')
                        <table class="table table-striped table-responsive">
                            <thead>
                            <th>Week</th>
                            <th>All</th>
                            <th>Type 0</th>
                            <th>Type 1</th>
                            <th>Type 2</th>
                            <th>Type 3</th>
                            <th>Type 4</th>
                            <th>Type 5</th>
                            <th>Type 6</th>
                            <th>Type 7</th>
                            <th>Type 8</th>
                            <th>Type 9</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card mt--2" id="optypes-daily">
                    <div class="card-header">Daily operations</div>
                    <div class="chart">
                        <canvas id="daily"></canvas>
                        @include('loading')
                        <table class="table table-striped table-responsive">
                            <thead>
                            <th>Day</th>
                            <th>All</th>
                            <th>Type 0</th>
                            <th>Type 1</th>
                            <th>Type 2</th>
                            <th>Type 3</th>
                            <th>Type 4</th>
                            <th>Type 5</th>
                            <th>Type 6</th>
                            <th>Type 7</th>
                            <th>Type 8</th>
                            <th>Type 9</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
