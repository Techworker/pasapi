@extends('layouts.app')

@section('script')
    <script src="{{ asset('js/richest.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <h1>Richest</h1>
        <hr class="div"/>
        <p>Richest accounts by account number.</p>
        <div class="row justify-content-center" id="chart-container">
            <div class="col-md-12">
                <div class="card mt--2" style="display: block">
                    <div class="card-header">Richest accounts</div>
                    <table class="table table-striped table-responsive" id="richest-table">
                        <thead>
                        <th>Account</th>
                        <th>Name</th>
                        <th>Balance</th>
                        <th>Type</th>
                        <th>Number of Ops</th>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection
