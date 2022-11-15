<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css" id="light-style">
</head>
<body>
  <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div style="width: 600px">
                <div class="card">
                    <!-- Logo -->
                    <div class="card-header pt-3 pb-3 text-center bg-info">
                        <img src="{{asset('images/email-sign.png')}}" alt="logo" style="object-fit: none; /* Do not scale the image */
                        object-position: 0px -100px; /* Center the image within the element */
                        width: 100%;
                        max-height: 150px;">
                    </div>
                    <div class="card-body p-4">
                      @yield('content')
                      <div class="mb-0 mt-3 text-center">
                        <p class="card-text">Este es un correo auto-generado no es necesario responderlo.</p>
                      </div>
                    </div> <!-- end card-body-->
                    <div class="card-footer text-center bg-info">
                      <p class="text-light m-0">
                        &reg; Instituto Tecnológico Superior de Lerdo<br/>Cd. Lerdo, Durango. {{ date('Y') }}<br/>
                      </p>
                    </div> <!-- end card-header-->
                </div>
                <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
  </div>
</body>
</html>