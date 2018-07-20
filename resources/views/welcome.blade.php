@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Yearly</div>
                    <canvas id="types_yearly" width="400" height="200"></canvas>
                </div>
                <div class="card">
                    <div class="card-header">Monthly</div>
                    <canvas id="types_monthly" width="400" height="200"></canvas>
                </div>
                <div class="card">
                    <div class="card-header">Weekly</div>
                    <canvas id="types_weekly" width="400" height="200"></canvas>
                </div>
                <div class="card">
                    <div class="card-header">Daily</div>
                    <canvas id="types_daily" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection
