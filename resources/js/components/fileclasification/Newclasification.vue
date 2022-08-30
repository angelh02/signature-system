<template>
    <div class="card-title">
        <h4>Agregar nueva clasificación</h4>
    </div>
    <form class="needs-validation" @submit.prevent="onSubmit" novalidate>
        <div class="mb-3">
            <label class="form-label" for="background_id">Fondo</label>
            <select
                class="form-select"
                id="background_id"
                name="background_id"
                v-model="formData.background_id"
                required
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option v-for="res in backGround" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="section_id">Sección</label>
            <select
                class="form-select"
                id="section_id"
                name="section"
                v-model="formData.section_id"
                required
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option v-for="res in section" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="row g-2">
            <label class="form-label">Serie y Subserie</label>
            <div class="mb-3 col-6">
                <div class="mb-3">
                    <input
                        type="text"
                        class="form-control"
                        id="series"
                        placeholder="Ingrese serie"
                        v-model="dataForm.series"
                        required
                    />
                    <div class="invalid-feedback">
                        Please provide a valid zip.
                    </div>
                </div>
            </div>
            <div class="mb-3 col-6">
                <div class="mb-3">
                    <input
                        type="text"
                        class="form-control"
                        id="subseries"
                        placeholder="Ingrese subserie"
                        v-model="formData.subseries"
                        required
                    />
                    <div class="invalid-feedback">
                        Please provide a valid zip.
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 mt-xxl-n3">
            <label class="form-label" for="production_area_id">Area de producción</label>
            <select
                class="form-select"
                id="production_area_id"
                name="productionArea"
                v-model="formData.production_area_id"
                required
            >
                <option :value="''" selected>Selecciona una opción...</option>
                <option v-for="res in productionArea" :value="res.id">
                    {{ `${res.code}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="row g-2">
            <div class="mb-3 col-6">
                <label class="form-label"
                    >Periodo Inicio</label
                >
                <div class="input-group date">
                    <input
                        v-model="formData.start_period"
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
            </div>
            <div class="mb-3 col-6">
                <label class="form-label"
                    >Periodo Fin</label
                >
                <div class="input-group date" id="end_period">
                    <input
                        autocomplete="off"
                        type="text"
                        class="form-control"
                        data-date-autoclose="true"
                        v-model="formData.end_period"
                        
                    />
                    <div class="input-group-addon">
                        <span class="uil-calendar-alt form-control"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-group date">
    <input type="text" class="form-control" value="12-02-2012">
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
</div>
        <div class="mb-3">
            <label class="form-label"
                >Consecutivo</label
            >
            <input
                type="text"
                class="form-control"
                id="consecutive_number"
                placeholder="Ingrese"
                v-model="formData.consecutive_number"
                required
            />
            <div class="invalid-feedback">Please provide a valid zip.</div>
        </div>
        <div class="row justify-items-center">
            <button class="btn btn-info mb-2" @click.prevent="editRequest">
                AGREGAR CLASIFICACIÓN
            </button>
            <button class="btn btn-light mb-2" type="submit">CANCELAR</button>
        </div>
    </form>
</template>

<script setup>
import { ref, onMounted, toRefs,toRef } from "vue";
import $ from "jquery";
import { useClasificationsRequests } from "@/js/composables/useClasificationsRequest.js";
import { useFormClasificationRequest } from "@/js/composables/useFormClasificationRequest.js";
import { datepicker } from "bootstrap-datepicker";
import useFileClasificationRequestsAPI from "@/api/index.js";

const props = defineProps({
    dataForm: Object,
    edit: Boolean
});

const dataForm = toRef(props, 'dataForm');
const edit = toRef(props, 'edit');
// console.log(dataForm);


const emit = defineEmits(['update'])

const backGround = ref("");
const section = ref("");
const productionArea = ref("");
const formData = ref(dataForm);
const reset = ref({
    background_id: "",
    section_id: "",
    series: "",
    subseries: "",
    production_area_id: "",
    start_period: "",
    end_period: "",
    consecutive_number: "",
})
// const editData = ref(dataForm)
const editData = ref({
    id:dataForm,
    background_id: dataForm.background_id,
    section_id: dataForm.section_id,
    series: dataForm.series,
    subseries: dataForm.subseries,
    production_area_id: dataForm.production_area_id,
    start_period: dataForm.start_period,
    end_period: dataForm.end_period,
    consecutive_number: dataForm.consecutive_number,
});
console.log(dataForm)
const addData = ref("");
const getId = ref("");
const starDate = ref("");
const endDate = ref("")

const { getBackground, getSection, getProductionArea, addClassification, editClassification } =
    useClasificationsRequests();

onMounted(async () => {
    await getRequests();
    $("#start_period").datepicker({
        language: "es",
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",

    });
    $("#start_period").on("change",function(){
        starDate.value = $(this).val();
    });
    $("#end_period").datepicker({
        language: "es",
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
    });
    $("#end_period").on("change",function(){
        endDate.value = $(this).val();
    });
});

const onSubmit = async (values) => {
    // if(dataForm != null){
    //     formData.value.series = dataForm.value.series
    // }
    // console.log(formData.value)
};

const getRequests = async () => {
    const resBackground = await getBackground("");
    backGround.value = resBackground;

    const resSection = await getSection("");
    section.value = resSection;

    const resProductionArea = await getProductionArea("");
    productionArea.value = resProductionArea;
};

const addRequest = async => {
        // console.log(editData.value)

    useFileClasificationRequestsAPI.addClassification(formData)
    .then((res) => {
        // console.log(res)
    });
    emit('update');
    onSubmit()
};

const editRequest = async => {
    console.log(dataForm.value)
    useFileClasificationRequestsAPI.editClassification(dataForm.value)
    .then((res) => {
        // console.log(res)
    });
    emit('update');
    dataForm.value = reset.value


}


// ellis85@example.com
</script>
