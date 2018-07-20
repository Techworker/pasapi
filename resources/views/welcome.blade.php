@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Yearly operations</div>
                    <canvas id="types_yearly" width="400" height="200"></canvas>
                </div>
                <div class="card">
                    <div class="card-header">Monthly operations</div>
                    <canvas id="types_monthly" width="400" height="200"></canvas>
                </div>
                <div class="card">
                    <div class="card-header">Weekly operations</div>
                    <canvas id="types_weekly" width="400" height="200"></canvas>
                </div>
                <div class="card">
                    <div class="card-header">Daily operations</div>
                    <canvas id="types_daily" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection
