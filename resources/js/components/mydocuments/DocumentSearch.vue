<template>
    <div class="card-title">
        <h4>¿Qué documentos te gustaría encontrar?</h4>
    </div>
    <form class="needs-validation" novalidate>
        <div>
            <label class="form-label">SÓLO MOSTRAR DOCUMENTOS QUE REQUIEREN FIRMA</label>
            <input type="checkbox" id="switch0" data-switch="none"/>
            <label for="switch0" data-on-label="" data-off-label=""></label>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="validationCustom06">NOMBRE DEL DOCUMENTO</label>
            <input type="text" class="form-control" id="validationCustom05" placeholder="Ingrese" required>
            <div class="invalid-feedback">
                Please provide a valid zip.
            </div>
        </div>
         <div class="mb-3">
            <label class="form-label" for="validationCustom06">FIRMANTES</label>
            <input type="text" class="form-control" id="validationCustom05" placeholder="Ingrese" required>
            <div class="invalid-feedback">
                Please provide a valid zip.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="validationCustom01">ESTADO DEL DOCUMENTO</label>
            <select class="form-select" id="validationCustom01" placeholder="Selección de fondo" value="" required>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="mb-3 position-relative" id="datepicker4">
            <label class="form-label">FECHA DE CREACIÓN</label>
            <input type="date" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-container="#datepicker4">
        </div>
        <div class="mb-3 position-relative" id="datepicker4">
            <label class="form-label">FECHA DE FIRMA</label>
            <input type="date" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-container="#datepicker4">
        </div>
    </form>
</template>