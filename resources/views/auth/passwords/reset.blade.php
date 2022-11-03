@extends('layouts.app')

@section('content')
<div class="container">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container pt-sm-5">
            <div class="row justify-content-center pt-5">
                <div class="col-4">
                    <div class="card">
                        {{-- <div class="card-header pt-4 pb-4 text-center bg-primary">
                        </div> --}}
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">Cambiar contraseña</h4>
                                <p class="text-muted mb-4">Ingresa tu contraseña actual y despues la nueva contraseña (Confirme su nueva contraseña)</p>
                            </div>
                            <form method="POST" action="{{ route('reset-password') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="current-password" class="form-label">{{ __('Contraseña actual') }}</label>

                                    <div class="mb-3">
                                        <div class="input-group input-group-merge">
                                            <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Ingresa contraseña actual" name="current_password" required autocomplete="current_password" autofocus>
                                            {{-- <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div> --}}
                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="form-label">{{ __('Contraseña nueva') }}</label>

                                    <div class="mb-3">
                                        <div class="input-group input-group-merge">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Ingresa contraseña nueva" required autocomplete="password">
                                            {{-- <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div> --}}
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="form-label">{{ __('Confirmar contraseña') }}</label>

                                    <div class="mb-3">
                                        <div class="input-group input-group-merge">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirma contraseña" required autocomplete="password-confirm">
                                            {{-- <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="mb-0 text-center">
                                        <button type="submit" class="btn btn-info">
                                            {{ __('Restablecer contraseña') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
