<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PascalCoin Stats</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    @yield('script')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-main">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="https://www.pascalcoin.org/images/logo.png" /> Transparency
                </a>
                <ul class="nav navbar-nav navbar-right navbar-main">
                    <li><span class="badge badge-pill badge-info">Block {{$latest_block_no}}</span></li>
                </ul>
            </div>
        </nav>

        <nav class="navbar navbar-expand-md navbar-light navbar-main">
            <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item{{Route::currentRouteName() === 'explorer_blocks' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('explorer_blocks')}}">Blocks</a>
                    </li>
                    <li class="nav-item dropdown {{Request::is('stats/*') ? 'active' : ''}}">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Statistics</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('stats_operations')}}">Operations</a>
                            <a class="dropdown-item" href="{{route('stats_volume')}}">Volume</a>
                            <a class="dropdown-item" href="{{route('stats_fees')}}">Fees</a>
                            <a class="dropdown-item" href="{{route('stats_miners')}}">Miners</a>
                            <a class="dropdown-item" href="{{route('stats_blocktime')}}">Block Time</a>
                            <a class="dropdown-item" href="{{route('stats_hashrate')}}">Hash rate</a>
                            <a class="dropdown-item" href="{{route('stats_foundation')}}">Foundation</a>
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right navbar-main">
                    <!--li><a class="nav-link" href="#" data-toggle="modal" data-target="#donate">Donate</a></li-->
                    <li class="nav-item{{Route::currentRouteName() === 'api' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('stats_api')}}">API</a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
        <!-- Modal -->
        <div class="modal fade" id="donate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Donation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Hi, my name is Benjamin Ansbach (@techworker on PascalCoin <a href="https://discord.gg/sJqcgtD">discord</a>). While you don't need to donate and can use this service free of charge, it would help me keep the service working and up-to-date.</p>
                        <p>So if you want to donate, send some PASC to account <b><u>55033</u></b>. If you include your discord username, I'll thank you personally ;-)</p>
                    </div>
                </div>
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
        <footer class="footer">
            <div class="container">
                <span class="text-muted">

                </span>
            </div>
        </footer>
    </div>
</body>
</html>
