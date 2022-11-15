@extends('layouts.app')

@section('content')
<div class="account-pages pt-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center pb-0 fw-bold">Iniciar Sesión</h4>
                            <p class="text-muted mb-4">Ingrese con su cuenta de google para acceder al panel de administración</p>
                        </div>
                        @if(false)
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Correo') }}</label>

                                <div class="">
                                    <input id="email" placeholder="Correo electrónico" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Contraseña') }}</label>

                                <div class="">
                                    <input id="password" placeholder="Contraseña" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-check form-checkbox-info">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Recuerdame') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="mb-3 mb-0 text-center">
                                    <button type="submit" class="btn btn-info col-6 rounded-3" >
                                        {{ __('Iniciar Sesión') }}
                                    </button>

                                    {{-- @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif --}}
                                </div>
                            </div>
                        </form>
                        @endif
                        <div class="row mb-0">
                            <div class="mb-3 mb-0 text-center">
                                <a id="signinButton" href="/login-google" class="btn btn-outline-danger rounded-3">
                                    <i class="mdi mdi-google me-2"></i>
                                    Iniciar con Google
                                </a>
                                @if (session('user'))
                                    <span class="d-block invalid-feedback" role="alert">
                                        <strong>{{ session('user') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection