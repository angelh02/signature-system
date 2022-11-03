@extends('email.email-template')

@section('content')
<div class="text-center m-auto">
    <h4 class="text-dark-50 text-center mt-3 fw-bold">Hola! Nombre del Firmante </h4>
    <p class="mb-4">Se te ha solicitado ser participante para firmar un documento</p>
</div>

<div class="mb-3">
    <h5 class="card-title">Información del Documento.</h5>
    <p class="card-text">Documento: </p>
    <p class="card-text">Tipo de documento: </p>
    <p class="card-text">Clasificación: </p>
    <p class="card-text">Contenedor: </p>
</div>

<div class="mb-3 mt-2 text-center">
    <a class="btn btn-info" href="/">IR AL SISTEMA</a>
</div>
@endsection