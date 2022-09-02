<script setup>
import { toRef,ref } from 'vue';
import VuePdfEmbed from 'vue-pdf-embed'

const emit = defineEmits(["showPreparation","close"]);

const source = "https://lpl.unbosque.edu.co/wp-content/uploads/08-Guia-Resumen.pdf"

const clasifications = toRef(props, 'clasifications');
const typesDocument = toRef(props, 'typesDocument');
const containers = toRef(props, 'containers');

const showPreparation = ref(false)
const props = defineProps({
    show: Boolean,
    clasifications: Object,
    typesDocument: Object,
    containers: Object
});


function sendDocument() {
    showPreparation.value = true
    emit('showPreparation',showPreparation.value)
    emit('close')
}

</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="modal-mask">
            <div class="card col-11 container-fluid my-4" >
                <div class="">
                    <div class="modal-content">
                        <!-- <div class="modal-header">
                            <button
                                type="button"
                                class="btn-close"
                                @click="$emit('close')"
                            ></button>
                        </div> -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <VuePdfEmbed :source="source" :width="800"  class="scrollspy-example"></VuePdfEmbed>
                                </div>
                                <div
                                    class="col-4 row mx-0 justify-content-center"
                                >
                                    <div class="">
                                        <div class="card-header">
                                            <h2>Preparación del documento</h2>
                                        </div>
                                        <div class="border-start">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="validationCustom06"
                                                        >NOMBRE DEL
                                                        DOCUMENTO</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        placeholder="Ingrese Nombre"
                                                        maxlength="30"
                                                        v-model="name"
                                                        required
                                                    />
                                                    <div
                                                        v-if="submit"
                                                        class="mensajeError"
                                                    >
                                                        Debe ingresar un nombre
                                                    </div>
                                                    <div
                                                        class="invalid-feedback"
                                                    >
                                                        Please provide a valid
                                                        zip.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
            <label class="form-label" for="background_id"
                >TIPO DE DOCUMENTO</label
            >
            <select
                class="form-select"
                id="background_id"
                name="background_id"
                required
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option value="" v-for="res in typesDocument" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
        </div>
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="background_id"
                                                        >CLASIFICACIÓN</label
                                                    >
                                                    <select
                                                        class="form-select"
                                                        id="background_id"
                                                        name="background_id"
                                                        required
                                                    >
                                                        <option
                                                            :value="''"
                                                            selected
                                                        >
                                                            Selecciona una
                                                            opción...
                                                        </option>
                                                        <option
                                                            value=""
                                                            v-for="res in clasifications"
                                                            :value="res.id"
                                                        >
                                                            {{ `${res.name}` }}
                                                        </option>
                                                    </select>
                                                    <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
                                                </div>
                                                <div class="mb-3">
            <label class="form-label" for="background_id">CONTENEDORES</label>
            <select
                class="form-select"
                id="background_id"
                name="background_id"
                required
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option value="" v-for="res in containers" :value="res.id">
                    {{ `${res.name}` }}
                </option>
            </select>
            <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
        </div>
                                                <div
                                                    class="card-footer border-0 mx-1 row justify-items-center"
                                                >
                                                    <button
                                                        class="btn btn-primary mb-2 col-5"
                                                        type="submit"
                                                        @click.prevent="sendDocument"
                                                    >
                                                        CONTINUAR
                                                    </button>
                                                    <button
                                                        class="btn btn-light mb-2 mx-3 col-5"
                                                        type="submit"
                                                        @click="$emit('close')"
                                                    >
                                                        CANCELAR
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card-footer">
                            <button
                                type="button"
                                class="btn btn-light"
                                @click="$emit('close')"
                            >
                                Close
                            </button>
                            <button type="button" class="btn btn-primary">
                                Save changes
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </Transition>
    <div
        id="standard-modal"
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="standard-modalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">
                        Modal Heading
                    </h4>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-hidden="true"
                    ></button>
                </div>
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</template>


<style>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}

.scrollspy-example{
    height: 838px
}
</style>
