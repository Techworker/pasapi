<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PascalCoin Stats</title>

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
                    <img src="https://www.pascalcoin.org/images/logo.png" /> Transparency<br />Block {{$latest_block_no}}
                </a>
            </div>
        </nav>

        <nav class="navbar navbar-expand-md navbar-light navbar-main">
            <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item{{Route::currentRouteName() === 'operations' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('operations')}}">Operations</a>
                    </li>
                    <li class="nav-item{{Route::currentRouteName() === 'volume' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('volume')}}">Volume</a>
                    </li>
                    <li class="nav-item{{Route::currentRouteName() === 'fees' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('fees')}}">Fees</a>
                    </li>
                    <li class="nav-item{{Route::currentRouteName() === 'miners' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('miners')}}">Miners</a>
                    </li>
                    <li class="nav-item{{Route::currentRouteName() === 'blocktime' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('blocktime')}}">Block Time</a>
                    </li>
                    <li class="nav-item{{Route::currentRouteName() === 'hashrate' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('hashrate')}}">Hash rate</a>
                    </li>
                    <li class="nav-item{{Route::currentRouteName() === 'foundation' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('foundation')}}">Foundation</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right navbar-main">
                    <li><a class="nav-link" href="#" data-toggle="modal" data-target="#donate">Donate</a></li>
                    <li class="nav-item{{Route::currentRouteName() === 'api' ? ' active' : ''}}">
                        <a class="nav-link" href="{{route('api')}}">API</a>
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
