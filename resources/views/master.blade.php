<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de firma</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css" id="light-style">    
</head>

<body>   
    <div id="app">
        @include('layouts.navbar')
        <div class="py-4">
            @yield('content')
        </div>  
    </div>    
    <script src="{{ asset('js/app.js') }}" defer></script>

</body>

</html>