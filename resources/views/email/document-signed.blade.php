@extends('email.email-template')

@section('content')
<div class="text-center m-auto">
    <h4 class="text-dark-50 text-center mt-3 fw-bold">Hola! Nombre del Creador </h4>
    <p class="text-muted mb-4">Se le notifica que su documento se ha firmado totalmente por los participantes.</p>
</div>

<div class="mb-3">
    <h5 class="card-title">Información del Documento.</h5>
    <p class="card-text">Documento: </p>
    <p class="card-text">Tipo de documento: </p>
    <p class="card-text">Clasificación: </p>
    <p class="card-text">Contenedor: </p>
</div>

<div class="text-center m-auto">
    <p class="text-muted mb-4">Porfavor ingresa al sistema para que puedas descargar el documento firmado.</p>
</div>

<div class="mb-3 mt-2 text-center">
    <a class="btn btn-info" href="/">IR AL SISTEMA</a>
</div>
@endsection