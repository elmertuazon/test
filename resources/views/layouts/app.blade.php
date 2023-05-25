<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <style>
        /* Fake image */
        .fakeimg {
            background-color: #aaa;
            width: 100%;
            padding: 20px;
        }
    </style>


    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('layouts.navigation')
        @if(Session::has('success'))
            <div id="session_notification" class="alert alert-success" role= "alert">
            <strong>Successful:</strong>
                {{ Session::pull('success') }} 
            </div>
        @endif
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('session_notification').style.display = 'none'
        }, 3000);
    </script>
</body>
</html>
