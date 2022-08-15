<template>
    <div class="card-title">
        <h4>Agregar nueva clasificación</h4>
    </div>
    <form class="needs-validation" novalidate>
        <div class="mb-3">
            <label class="form-label" for="validationCustom01">Fondo</label>
            <select class="form-select" id="validationCustom01" placeholder="Selección de fondo" value="" required>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="validationCustom02">Sección</label>
            <select class="form-select" id="validationCustom02" placeholder="Selección de sección" value="" required>
                <option placeholder="sss" value=""></option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="row g-2">
            <label class="form-label">Serie y Subserie</label>
            <div class="mb-3 col-6">
                <!-- <label class="" for="validationCustom05"></label> -->
                <select class="form-select" id="validationCustom02" placeholder="Selección de serie" value="" required>
                    <option placeholder="sss" value=""></option>
                </select>
                <div class="invalid-feedback">
                    Please provide a valid zip.
                </div>
            </div>
            <div class="mb-3 col-6">
                <!-- <label class="" for="validationCustom05"></label> -->
                <select class="form-select" id="validationCustom02" placeholder="Selección de subserie" value="" required>
                    <option placeholder="sss" value=""></option>
                </select>
                <div class="invalid-feedback">
                    Please provide a valid zip.
                </div>
            </div>
        </div>
       
        <div class="mb-3">
            <label class="form-label" for="validationCustom05">Consecutivo</label>
            <input type="text" class="form-control" id="validationCustom05" placeholder="Ingrese" required>
            <div class="invalid-feedback">
                Please provide a valid zip.
            </div>
        </div>
        <div class="row justify-items-center">
            <button class="btn btn-info mb-2" type="submit">AGREGAR CLASIFICACIÓN</button>
            <button class="btn btn-light mb-2" type="submit">CANCELAR</button>
        </div>
        
    </form>
</template>