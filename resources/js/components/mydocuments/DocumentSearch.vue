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
                v-model="filterData.document_type"
                @change="returnFilterData"
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option v-for="res in documentType" :value="res.id">
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
                v-model="filterData.classification"
                @change="returnFilterData"
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option v-for="res in clasification" :value="res.id">
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
                v-model="filterData.container"
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
import { ref, onMounted, toRefs, toRef, reactive } from "vue";
import $ from "jquery";
import { datepicker } from "bootstrap-datepicker";
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentsRequest.js";

const emit = defineEmits(['clasification','typeDocument','container','filterData'])


const name = ref("")
const firmantes = ref("")
const documentType = ref("")
const clasification = ref("")
const containers = ref("")
const fechaFirma = ref("")
const fechaCreacion = ref("")

const filterData = ref({
    signed:0,
    name:"",
    document_type:0,
    classification:0,
    container:0
})
const document = ref("")
const clas = ref("")
const cont = ref("")



const { getDocumentsType, getClasification,getContainers } =
    useDocumentsRequests();

onMounted(async () => {
    await getRequests();
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

const getRequests = async () => {
    const resdocumentType = await getDocumentsType("");
    documentType.value = resdocumentType;
    emit('typeDocument',documentType.value);


    const resClasification = await getClasification("");
    clasification.value = resClasification;
    emit('clasification',clasification.value);

    const resContainer = await getContainers("");
    containers.value = resContainer;
    emit('container',containers.value);

    emit('filterData',filterData.value);
   
    
};
</script>
