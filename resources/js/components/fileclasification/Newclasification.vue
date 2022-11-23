<template>
    <div class="card-title">
        <h4 v-if="!edit">Agregar nueva clasificación</h4>
        <h4 v-if="edit">Editar clasificación</h4>
    </div>
    <form class="needs-validation" @submit.prevent="onSubmit" novalidate>
        <div class="mb-3">
            <label class="form-label" for="background_id">Fondo</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <select
                    class="form-select"
                    id="background_id"
                    name="background_id"
                    v-model="v$.background_id.$model"
                    required
                >
                    <option :value="''" selected>Selecciona una opción...</option>
                    <option v-for="res in backGround" :value="res.id">
                        {{ `${res.code}` }} - {{ `${res.name}` }}
                    </option>
                </select>
                <div v-for="(error, index) in v$.background_id.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="section_id">Sección</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <select
                    class="form-select"
                    id="section_id"
                    name="section"
                    v-model="v$.section_id.$model"
                    required
                >
                    <option :value="''" selected>Selecciona una opción...</option>
                    <option v-for="res in section" :value="res.id">
                        {{ `${res.code}` }} - {{ `${res.name}` }}
                    </option>
                </select>
                <div v-for="(error, index) in v$.section_id.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="form-label">Serie y Sub serie</label>
            <div class="col-6">
                <div class="">
                    <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                        <input
                            type="text"
                            class="form-control"
                            id="series"
                            placeholder="Ingrese serie"
                            v-model="v$.series.$model"
                            required
                        />
                        <div v-for="(error, index) in v$.series.$errors" :key="index" class="invalid-feedback d-block">
                            {{ error.$message }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="">
                    <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                        <input
                            type="text"
                            class="form-control"
                            id="subseries"
                            placeholder="Ingrese sub serie"
                            v-model="v$.subseries.$model"
                            required
                        />
                        <div v-for="(error, index) in v$.subseries.$errors" :key="index" class="invalid-feedback d-block">
                            {{ error.$message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="production_area_id">Área de producción</label>
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <select
                    class="form-select"
                    id="production_area_id"
                    name="productionArea"
                    v-model="v$.production_area_id.$model"
                    required
                >
                    <option :value="''" selected>Selecciona una opción...</option>
                    <option v-for="res in productionArea" :value="res.id">
                        {{ `${res.code}` }} - {{ `${res.name}` }}
                    </option>
                </select>
                <div v-for="(error, index) in v$.production_area_id.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="mb-3 col-6">
                <label class="form-label"
                    >Periodo Inicio</label
                >
                <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                    <div class="input-group date">
                        <input
                            v-model="v$.start_period.$model"
                            autocomplete="off"
                            type="text"
                            class="form-control"
                            data-date-autoclose="true"
                            id="start_period"
                        />
                        <div class="input-group-addon">
                            <span class="uil-calendar-alt form-control"></span>
                        </div>
                    </div>
                    <div v-for="(error, index) in v$.start_period.$errors" :key="index" class="invalid-feedback d-block">
                        {{ error.$message }}
                    </div>
                </div>
            </div>
            <div class="mb-3 col-6">
                <label class="form-label"
                    >Periodo Fin</label
                >
                <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                    <div class="input-group date" >
                        <input
                            autocomplete="off"
                            type="text"
                            class="form-control"
                            data-date-autoclose="true"
                            v-model="v$.end_period.$model"
                            id="end_period"
                        />
                        <div class="input-group-addon">
                            <span class="uil-calendar-alt form-control"></span>
                        </div>
                    </div>
                    <div v-for="(error, index) in v$.end_period.$errors" :key="index" class="invalid-feedback d-block">
                        {{ error.$message }}
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >Consecutivo</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="text"
                    class="form-control"
                    id="consecutive_number"
                    placeholder="Ingrese"
                    v-model="v$.consecutive_number.$model"
                    required
                />
                <div v-for="(error, index) in v$.consecutive_number.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="row justify-items-center">
            <button v-if="!edit" class="btn btn-primary mb-2" type="submit" @click.prevent="addRequest" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">
                AGREGAR CLASIFICACIÓN
            </button>
            <button v-if="edit" class="btn btn-primary mb-2" type="submit" @click.prevent="editRequest" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">
                ACTUALIZAR CLASIFICACIÓN
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
import { useToast } from "vue-toastification";
//Api functions
import { useClasificationsRequests } from "@/js/composables/useClasificationsRequest.js";
import { useFormClasificationRequest } from "@/js/composables/useFormClasificationRequest.js";
import useFileClasificationRequestsAPI from "@/api/index.js";

const toast = useToast();
const props = defineProps({
    dataForm: Object,
    edit: Boolean
});

//ReadOnly
const dataForm = toRef(props, 'dataForm');
const edit = toRef(props, 'edit');


const emit = defineEmits(['update','cancel'])

const submit = ref(false)
const backGround = ref("");
const section = ref("");
const productionArea = ref("");
const starDate = ref("");
const endDate = ref("")
//ReactiveProps
const formData = reactive(dataForm);


const { getBackground, getSection, getProductionArea, addClassification, editClassification } =
    useClasificationsRequests();

const rules = {
    background_id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
    section_id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
    series : {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        maxLength: helpers.withMessage('Este campo no debe tener mas de 10 caracters', maxLength(10)),
    },
    subseries : {maxLength: helpers.withMessage('Este campo no debe tener mas de 10 caracters', maxLength(10)),},
    production_area_id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
    start_period : {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        numeric : helpers.withMessage('Debe ser un valor numerico', numeric)
    },
    end_period : {
        numeric : helpers.withMessage('Debe ser un valor numerico', numeric)
    },
    consecutive_number : {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        numeric : helpers.withMessage('Debe ser un valor numerico', numeric),
        minValue : helpers.withMessage('El valor minimo debe ser 1', minValue(1))
    },
}

const state = reactive(formData);
const v$ = useVuelidate(rules, formData)

onMounted(async () => {
    await getRequests();
    $("#start_period").datepicker({
        language: "es",
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",

    });
    $("#start_period").on("change",function(){
        formData.value.start_period  = $(this).val();
    });
    $("#end_period").datepicker({
        language: "es",
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
    });
    $("#end_period").on("change",function(){
        formData.value.end_period = $(this).val();
    });
});

const getRequests = async () => {
    const resBackground = await getBackground("");
    backGround.value = resBackground;

    const resSection = await getSection("");
    section.value = resSection;

    const resProductionArea = await getProductionArea("");
    productionArea.value = resProductionArea;
};

const addRequest = async => {
    if(!(v$._value.$errors.length > 0 || v$._value.$silentErrors.length > 0))
    {
        useFileClasificationRequestsAPI.addClassification(formData.value)
        .then((res) => {
            toast.success("Se ha agregado correctamente el archivo de clasificación", {
            timeout: 2000,
            });

            emit('update');
            resetData();
        })
        .catch(error => 
            toast.warning("No se ha podido agregar, verifique los datos (ej. nombre repetido, etc..)", {
            timeout: 2000,
            })
        );
    }
};

const editRequest = async => {
    if(!(v$._value.$errors.length > 0 || v$._value.$silentErrors.length > 0))
    {
        useFileClasificationRequestsAPI.editClassification(formData.value)
        .then((res) => {
            //toast
            toast.success("Se ha editado correctamente la clasificación", {
            timeout: 2000,
            });

            emit('update');
            resetData();
        })
        .catch(error => 
            toast.warning("No se ha podido editar, verifique los datos.", {
            timeout: 2000,
            })
        );
    }
    
}

function resetData(){
    
    formData.value.id = null;
    formData.value.background_id = "";
    formData.value.section_id = "";
    formData.value.series = "";
    formData.value.subseries = "";
    formData.value.production_area_id = "";
    formData.value.start_period = "";
    formData.value.end_period = "";
    formData.value.consecutive_number = "";
    v$._value.$reset();
    emit('cancel');
}
</script>
