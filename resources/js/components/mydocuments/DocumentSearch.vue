<template>
    <div class="card-title">
        <h4>¿Qué documentos te gustaría encontrar?</h4>
    </div>
    <form class="row align-items-center" novalidate>
        <!-- <div>
            <label class="form-label"
                >SÓLO MOSTRAR DOCUMENTOS QUE REQUIEREN FIRMA</label
            >
            <input type="checkbox" id="switch0" data-switch="none" v-model="filterData.signed " @change="returnFilterData"/>
            <label for="switch0" data-on-label="" data-off-label=""></label>
        </div> -->

        <div class="col mb-3">
            <label class="form-label" for="validationCustom06"
                >NOMBRE DEL DOCUMENTO</label
            >
            <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Ingrese Nombre"
                maxlength="30"
                v-model="filterData.name"
                @keyup.enter="returnFilterData"
                required
            />
            <div v-if="submit " class="mensajeError">
                Debe ingresar un nombre
            </div>
            <div class="invalid-feedback">Please provide a valid zip.</div>
        </div>
        <!-- <div class="mb-3">
            <label class="form-label" for="validationCustom06">FIRMANTES</label>
           <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Ingrese Nombre"
                maxlength="30"
                v-model="firmantes"
                required
            />
            <div v-if="submit " class="mensajeError">
                Debe ingresar un nombre
            </div>
            <div class="invalid-feedback">Please provide a valid zip.</div>
        </div> -->
        <!-- <div class="mb-3 position-relative" id="datepicker4">
            <label class="form-label">FECHA DE CREACIÓN</label>
             <div class="input-group date">
                <input
                    v-model="fechaCreacion"
                    autocomplete="off"
                    type="text"
                    class="form-control"
                    data-date-autoclose="true"
                    id="created_at"
                    readonly
                />
                <div class="input-group-addon">
                    <span class="uil-calendar-alt form-control"></span>
                </div>
            </div>
        </div> -->
        <!-- <div class="mb-3 position-relative" id="datepicker4">
            <label class="form-label">FECHA DE FIRMA</label>
             <div class="input-group date">
                <input
                    v-model="fechaFirma"
                    autocomplete="off"
                    type="text"
                    class="form-control"
                    data-date-autoclose="true"
                    id="signed_at"
                    readonly
                />
                <div class="input-group-addon">
                    <span class="uil-calendar-alt form-control"></span>
                </div>
            </div>
        </div> -->
        <div class="col mb-3">
            <label class="form-label" for="background_id"
                >TIPO DE DOCUMENTO</label
            >
            <select
                class="form-select"
                id="background_id"
                name="background_id"
                required
                v-model="filterData.document_type_id"
                @change="returnFilterData"
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option v-for="res in documentTypes" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
        </div>
        <div class="col mb-3">
            <label class="form-label" for="background_id">CLASIFICACIÓN</label>
            <select
                class="form-select"
                id="background_id"
                name="background_id"
                required
                v-model="filterData.classification_id"
                @change="returnFilterData"
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option v-for="res in classifications" :value="res.id">
                    {{ `${res.name}` }}
                </option>
            </select>
            <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
        </div>
        <div class="col mb-3">
            <label class="form-label" for="background_id">CONTENEDORES</label>
            <select
                class="form-select"
                id="background_id"
                name="background_id"
                required
                v-model="filterData.container_id"
                @change="returnFilterData"
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option v-for="res in containers" :value="res.id">
                    {{ `${res.name}` }}
                </option>
            </select>
            <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
        </div>
    </form>
</template>

<script setup>
//Libraries
import { ref, onMounted, toRefs, toRef, reactive } from "vue";
import $ from "jquery";
import { datepicker } from "bootstrap-datepicker";
//Apis
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentsRequest.js";

const emit = defineEmits(['filterData']);

const props = defineProps({
    classifications: Object,
    documentTypes: Object,
    containers: Object,
});

const name = ref("")
const firmantes = ref("")
const classifications = toRef(props, "classifications");
const documentTypes = toRef(props, "documentTypes");
const containers = toRef(props, "containers");
const fechaFirma = ref("")
const fechaCreacion = ref("")

const filterData = ref({
    name:"",
    document_type_id:"",
    classification_id:"",
    container_id:""
})
const document = ref("")
const clas = ref("")
const cont = ref("")



const { getDocumentsType, getClasification,getContainers } =
    useDocumentsRequests();

onMounted(async () => {
    $("#created_at").datepicker({
        language: "es",
        format: "yyyy-mm-dd"

    });
    $("#created_at").on("change",function(){
       fechaCreacion.value  = $(this).val();
    });$("#signed_at").datepicker({
        language: "es",
        format: "yyyy-mm-dd"

    });
    $("#signed_at").on("change",function(){
        fechaFirma.value  = $(this).val();
    });
});

function returnFilterData () {
    emit('filterData',filterData.value);
}


</script>
