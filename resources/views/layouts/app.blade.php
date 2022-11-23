<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Sistema de firma') }}</title> --}}
    <title>ITSL - eGestión</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/itsl-logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/itsl-logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/itsl-logo.png') }}">

    <!-- Styles -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css" id="light-style"> 
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>
</html>
