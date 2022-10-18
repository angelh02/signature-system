<template>
    <div class="card-title">
        <h4>Agregar nueva clasificación</h4>
    </div>
    <form class="needs-validation" @submit.prevent="onSubmit" novalidate>
        <!-- Controles para informacion del contenedor -->
        <div class="mb-3">
            <label class="form-label" for="name">Nombre</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Ingrese Nombre"
                    maxlength="30"
                    v-model="v$.name.$model"
                    required
                />
                <div v-for="(error, index) in v$.name.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="conservation_time_id">Tiempo de conservación</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">                
                <select
                    class="form-select"
                    id="conservation_time_id"
                    name="conservation_time_id"
                    v-model="v$.conservation_time_id.$model"
                    required
                >
                    <option value="" disabled selected>Selecciona una opción...</option>
                    <option v-for="res in conservationTimes" :value="res.id">
                        {{ `${res.code}` }} - {{ `${res.name}` }}
                    </option>
                </select>
                <div v-for="(error, index) in v$.conservation_time_id.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="conservation_type_id">Tipo de conservación</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <select
                    class="form-select"
                    id="conservation_type_id"
                    name="conservation_type_id"
                    v-model="v$.conservation_type_id.$model"
                    required
                >
                    <option value="" disabled selected>Selecciona una opción...</option>
                    <option v-for="res in conservationTypes" :value="res.id">
                        {{ `${res.code}` }} - {{ `${res.name}` }}
                    </option>
                </select>
                <div v-for="(error, index) in v$.conservation_type_id.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="document_value_id">Valor documental</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }"> 
                <select
                    class="form-select"
                    id="document_value_id"
                    name="document_value_id"
                    v-model="v$.document_value_id.$model"
                    required
                >
                    <option value="" disabled selected>Selecciona una opción...</option>
                    <option v-for="res in documentValues" :value="res.id">
                        {{ `${res.code}` }} - {{ `${res.name}` }}
                    </option>
                </select>
                <div v-for="(error, index) in v$.document_value_id.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="information_type_id">Tipo de información</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <select
                    class="form-select"
                    id="information_type_id"
                    name="informationTypes"
                    v-model="v$.information_type_id.$model"
                    required
                >
                    <option value="" disabled selected>Selecciona una opción...</option>
                    <option v-for="res in informationTypes" :value="res.id">
                        {{ `${res.code}` }} - {{ `${res.name}` }}
                    </option>
                </select>
                <div v-for="(error, index) in v$.information_type_id.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3 ">
            <label class="form-label" for="selection_technique_id">Tecnica de selección</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }"> 
                <select
                    class="form-select"
                    id="selection_technique_id"
                    name="selectionTechnique"
                    v-model="v$.selection_technique_id.$model"
                    required
                >
                    <option value="" disabled selected>Selecciona una opción...</option>
                    <option v-for="res in selectionTechniques" :value="res.id">
                        {{ `${res.code}` }} - {{ `${res.name}` }}
                    </option>
                </select>
                <div v-for="(error, index) in v$.selection_technique_id.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >Fecha efectiva</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <div class="input-group date">
                    <input
                        v-model="v$.effective_date.$model"
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
                <div v-for="(error, index) in v$.effective_date.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <!-- Botones para modificar info -->
        <div class="row justify-items-center">
            <button v-if="!edit" class="btn btn-primary mb-2" type="submit" @click.prevent="addRequest" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">
                AGREGAR CONTENEDOR
            </button>
            <button v-if="edit" class="btn btn-primary mb-2" type="submit" @click.prevent="editRequest" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">
                ACTUALIZAR CONTENEDOR
            </button>
            <button class="btn btn-light mb-2" type="submit" @click="resetData">CANCELAR</button>
        </div>
    </form>
</template>

<script setup>
//Libraries
import { useVuelidate } from '@vuelidate/core';
import { required, numeric ,minValue, helpers, minLength, maxLength} from '@vuelidate/validators';
import { ref, onMounted, toRefs, toRef, reactive } from "vue";
import $ from "jquery";
import { datepicker } from "bootstrap-datepicker";
//Api functions
import { useContainersRequests } from "@/js/composables/container-apis/useContainersRequest.js";
import { useFormContainerRequest } from "@/js/composables/container-apis/useFormContainerRequest.js";
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
    name : {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        minLength: helpers.withMessage('Este campo debe tener minimo 5 caracters', minLength(5)),
        maxLength: helpers.withMessage('Este campo no debe tener mas de 10 caracters', maxLength(10)),
    },
    document_value_id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
    conservation_time_id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
    selection_technique_id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
    conservation_type_id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
    information_type_id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
    effective_date : {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
    },
}

const state = reactive(formData);
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
    if(!(v$._value.$errors.length > 0 || v$._value.$silentErrors.length > 0))
    {
        useContainerRequestsAPI.addContainer(formData.value)
        .then((res) => {
            //toast
        });
        emit('update');
        resetData();
    }
};

const editRequest = async => {
    if(!(v$._value.$errors.length > 0 || v$._value.$silentErrors.length > 0))
    {
        useContainerRequestsAPI.editContainer(formData.value)
        .then((res) => {
            //toast
        });
        emit('update');
        resetData();
    }
}

function resetData(){
    formData.value.id = null;
    formData.value.name = "";
    formData.value.conservation_time_id = "";
    formData.value.conservation_type_id = "";
    formData.value.document_value_id = "";
    formData.value.information_type_id = "";
    formData.value.selection_technique_id = "";
    formData.value.effective_date = "";
    v$._value.$reset();
    emit('cancel');
}
</script>

