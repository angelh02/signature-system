@extends('email.email-template')

@section('content')
<div class="text-center m-auto">
    <h4 class="text-dark-50 text-center mt-3 fw-bold">Hola! Nombre del Firmante </h4>
    <p class="text-muted mb-4">Este es un mensaje de confirmación al haber firmado exitosamente.</p>
</div>

<div class="mb-3">
    <h5 class="card-title">Lista de documentos firmados.</h5>
    <ul>
        <li><p class="card-text">Documento</p></li>
        <li><p class="card-text">Documento</p></li>
        <li><p class="card-text">Documento</p></li>
        <li><p class="card-text">Documento</p></li>
        <li><p class="card-text">Documento</p></li>
    </ul>
</div>
@endsection