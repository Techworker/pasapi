@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt--2">
                    <div class="card-header">Yearly operations</div>
                    <canvas id="types_yearly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Monthly operations</div>
                    <canvas id="types_monthly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Weekly operations</div>
                    <canvas id="types_weekly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Daily operations</div>
                    <canvas id="types_daily" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mt--2">
                    <div class="card-header">Yearly volume</div>
                    <canvas id="volume_yearly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Monthly volume</div>
                    <canvas id="volume_monthly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Weekly volume</div>
                    <canvas id="volume_weekly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Daily volume</div>
                    <canvas id="volume_daily" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mt--2">
                    <div class="card-header">Yearly fees</div>
                    <canvas id="fee_yearly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Monthly fees</div>
                    <canvas id="fee_monthly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Weekly fees</div>
                    <canvas id="fee_weekly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Daily fees</div>
                    <canvas id="fee_daily" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mt--2">
                    <div class="card-header">Yearly miners</div>
                    <canvas id="miner_yearly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Monthly miners</div>
                    <canvas id="miner_monthly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Weekly miners</div>
                    <canvas id="miner_weekly" width="400" height="200"></canvas>
                </div>
                <div class="card mt--2">
                    <div class="card-header">Daily miners</div>
                    <canvas id="miner_daily" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection
