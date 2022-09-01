<template>
    <div class="card-title">
        <h4>Agregar nueva clasificación</h4>
    </div>
    <form class="needs-validation" @submit.prevent="onSubmit" novalidate>
        <!-- Controles para informacion del contenedor -->
        <div class="mb-3">
            <label class="form-label" for="name">Nombre</label>
            <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Ingrese Nombre"
                maxlength="30"
                v-model="dataForm.name"
                required
            />
            <div v-if="submit " class="mensajeError">
                Debe ingresar un nombre
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="conservation_time_id">Tiempo de conservación</label>
            <select
                class="form-select"
                id="conservation_time_id"
                name="conservation_time_id"
                v-model="formData.conservation_time_id"
                required
            >
                <option :value="0" disabled selected>Selecciona una opción...</option>
                <option v-for="res in conservationTimes" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div v-if="submit && !$v.conservation_time_id.required" class="mensajeError">
                Debe escoger una opcion gilipolla
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="conservation_type_id">Tipo de conservación</label>
            <select
                class="form-select"
                id="conservation_type_id"
                name="conservation_type_id"
                v-model="formData.conservation_type_id"
                required
            >
                <option :value="0" disabled selected>Selecciona una opción...</option>
                <option v-for="res in conservationTypes" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="document_value_id">Valor documental</label>
            <select
                class="form-select"
                id="document_value_id"
                name="document_value_id"
                v-model="formData.document_value_id"
                required
            >
                <option :value="0" disabled selected>Selecciona una opción...</option>
                <option v-for="res in documentValues" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="mb-3 mt-xxl-n3">
            <label class="form-label" for="information_type_id">Tipo de información</label>
            <select
                class="form-select"
                id="information_type_id"
                name="informationTypes"
                v-model="formData.information_type_id"
                required
            >
                <option :value="0" disabled selected>Selecciona una opción...</option>
                <option v-for="res in informationTypes" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="mb-3 mt-xxl-n3">
            <label class="form-label" for="selection_technique_id">Tecnica de selección</label>
            <select
                class="form-select"
                id="selection_technique_id"
                name="selectionTechnique"
                v-model="formData.selection_technique_id"
                required
            >
                <option :value="0" disabled selected>Selecciona una opción...</option>
                <option v-for="res in selectionTechniques" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >Fecha efectiva</label
            >
            <div class="input-group date">
                <input
                    v-model="formData.effective_date"
                    autocomplete="off"
                    type="text"
                    class="form-control"
                    data-date-autoclose="true"
                    id="effective_date"
                    readonly
                />
                <div class="input-group-addon">
                    <span class="uil-calendar-alt form-control"></span>
                </div>
            </div>
        </div>
        <!-- Botones para modificar info -->
        <div class="row justify-items-center">
            <button v-if="!edit" class="btn btn-primary mb-2" type="submit" @click.prevent="addRequest">
                AGREGAR CONTENEDOR
            </button>
            <button v-if="edit" class="btn btn-primary mb-2" type="submit" @click.prevent="editRequest">
                ACTUALIZAR CONTENEDOR
            </button>
            <button class="btn btn-light mb-2" type="submit" @click="resetData">CANCELAR</button>
        </div>
    </form>
</template>

<script setup>
import useVuelidate from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { ref, onMounted, toRefs, toRef, reactive } from "vue";
import $ from "jquery";
import { useContainersRequests } from "@/js/composables/container-apis/useContainersRequest.js";
import { useFormContainerRequest } from "@/js/composables/container-apis/useFormContainerRequest.js";
import { datepicker } from "bootstrap-datepicker";
import useContainerRequestsAPI from "@/api/container/index.js";

const props = defineProps({
    dataForm: Object,
    edit: Boolean
});

//ReadOnly
const dataForm = toRef(props, 'dataForm');
const edit = toRef(props, 'edit');


const emit = defineEmits(['update','cancel'])

const submit = ref(false)
const conservationTimes = ref("");
const conservationTypes = ref("");
const documentValues = ref("");
const informationTypes = ref("");
const selectionTechniques = ref("");
const starDate = ref("");
const endDate = ref("")
//ReactiveProps
const formData = reactive(dataForm);


const { getConservationTimes, getConservationTypes, getDocumentValues, getInformationTypes, getSelectionTechniques, addContainer, editContainer } =
    useContainersRequests();

const rules = {
      firstName: { required }, // Matches state.firstName
      lastName: { required }, // Matches state.lastName
      formData: {
        conservation_time_id: { required },
        name: {required} // Matches state.contact.email
      }
    }

const v$ = useVuelidate(rules, formData)

onMounted(async () => {
    await getRequests();
    $("#effective_date").datepicker({
        language: "es",
        format: "yyyy-mm-dd"

    });
    $("#effective_date").on("change",function(){
        formData.value.effective_date  = $(this).val();
    });
});

const onSubmit = async (values) => {
    // alert("yep")
    // submit.value = true
    // if($v.$invalid){
    //     return;
    // }
};

const getRequests = async () => {
    const resConservationTimes = await getConservationTimes("");
    conservationTimes.value = resConservationTimes;

    const resConservationTypes = await getConservationTypes("");
    conservationTypes.value = resConservationTypes;

    const resDocumentValues = await getDocumentValues("");
    documentValues.value = resDocumentValues;

    const resInformationTypes = await getInformationTypes("");
    informationTypes.value = resInformationTypes;

    const resSelectionTechniques = await getSelectionTechniques("");
    selectionTechniques.value = resSelectionTechniques;
};

const addRequest = async => {
    useContainerRequestsAPI.addContainer(formData.value)
    .then((res) => {
    });
    emit('update');
    resetData();
    onSubmit()
};

const editRequest = async => {
    onSubmit()
   
    useContainerRequestsAPI.editContainer(formData.value)
    .then((res) => {
    //     $.NotificationApp.send(
    //     "Correcto",
    //     formData.value.id
    //         ? "El formulario del estudiante se actualizo correctamente"
    //         : "El formulario del estudiante se registro correctamente",
    //     "bottom-right",
    //     "DarkGreen",
    //     "success"
    // );
    });
    emit('update');
    resetData();
}

function resetData(){
    formData.value.id = null;
    formData.value.name = "";
    formData.value.conservation_time_id = 0;
    formData.value.conservation_type_id = 0;
    formData.value.document_value_id = 0;
    formData.value.information_type_id = 0;
    formData.value.selection_technique_id = 0;
    formData.value.effective_date = "";
    emit('cancel');
}
</script>

