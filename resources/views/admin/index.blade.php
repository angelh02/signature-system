<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSL - eGestión</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css" id="light-style">    
</head>
<style>
    /* @media screen and (min-width:914px){
        h5{
            font-size: 10px;
        },
        .mx-auto{
            margin-right: 0%;
            margin-left: 0%;
        }
        .col{
            flex: 1 0 0%
        }
    }
    @media screen and (max-width:914px){
        h5{
            font-size: 8px;
        },
        .mx-auto{
            margin-right: 0%;
            margin-left: 0%;
        }
        .col{
            flex: 1 0 0%
        }
    }
    @media screen and (max-width:572px){
        h5{
            font-size: 10px;
        },
        .mx-auto{
            margin-right: 0%;
            margin-left: 0%;
        }
        .col{
            flex: 1 0 100%
        }
        .fe{
            margin-top: -4.5rem !important;
            margin-bottom: -4.5rem !important;
            margin-right: -4.5rem !important;
            margin-left: -4.5rem !important;
        }
        .fer{
            margin-top: -0.5rem !important;
            margin-bottom: -4.5rem !important;
            margin-right: -6.5rem !important;
            margin-left: -9.5rem !important;
        }
    } */
    /* @media screen and (max-width:572px){
        .py-5 {
            padding-top: 8.5rem !important;
            padding-bottom: 4.5rem !important;
         }
    } */
</style>
<body>   
    <div id="app">
        @include('admin.layout.navbar')
        <div class="py-4">
            <div class="container-fluid">
                <div class="row justify-content-center py-5">
                    <router-view :user="{{Auth::user()->makeVisible(['aws_auth_token'])}}"/>
                </div>
            </div>
        </div>  
    </div>    
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>