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
            <div v-if="submit && !$v.background_id.required" class="mensajeError">
                Debe escoger una opcion gilipolla
            </div>
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
                    <div v-if="submit " class="mensajeError">
                        Debe escoger una opcion gilipolla
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
            <button v-if="!edit" class="btn btn-primary mb-2" type="submit" @click.prevent="addRequest">
                AGREGAR CLASIFICACIÓN
            </button>
            <button v-if="edit" class="btn btn-primary mb-2" type="submit" @click.prevent="editRequest">
                ACTUALIZAR CLASIFICACIÓN
            </button>
            <button class="btn btn-light mb-2" type="submit" @click="setForm">CANCELAR</button>
        </div>
    </form>
</template>

<script setup>
import useVuelidate from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { ref, onMounted, toRefs, toRef, reactive } from "vue";
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

const submit = ref(false)
const backGround = ref("");
const section = ref("");
const productionArea = ref("");
const formData = reactive(dataForm);
const initialState = ref({
    background_id: "",
    section_id: "",
    series: "",
    subseries: "",
    production_area_id: "",
    start_period: "",
    end_period: "",
    consecutive_number: "",
})
const addData = ref({
    background_id: formData.background_id,
    section_id: formData.value.section_id,
    series: formData.value.series,
    subseries: formData.value.subseries,
    production_area_id: formData.value.production_area_id,
    start_period: formData.value.start_period,
    end_period: formData.value.end_period,
    consecutive_number: formData.value.consecutive_number,
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
// const addData = ref("");
const getId = ref("");
const starDate = ref("");
const endDate = ref("")
const form = reactive({ ...dataForm });


const { getBackground, getSection, getProductionArea, addClassification, editClassification } =
    useClasificationsRequests();

const rules = {
      firstName: { required }, // Matches state.firstName
      lastName: { required }, // Matches state.lastName
      formData: {
        background_id: { required },
        series: {required} // Matches state.contact.email
      }
    }

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
    // alert("yep")
    // submit.value = true
    // if($v.$invalid){
    //     return;
    // }
    console.log(form)
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
    // console.log("Datos",formData.value)
    useFileClasificationRequestsAPI.addClassification(formData.value)
    .then((res) => {
        // console.log(res)
    });
    emit('update');
    onSubmit()
};

const editRequest = async => {
    onSubmit()
    // console.log(formData.value)
    // console.log(dataForm.value)
    useFileClasificationRequestsAPI.editClassification(formData.value)
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
    // console.log("Satos",addData.value)
    // dataForm.value = reset.value


}

// function resetData(){
//     edit.value = true;
//     formData.value = reset.value
//     console.log(formData.value)
//     // formData.id = null;
//     // formData.background_id = 0;
//     // formData.section_id = 0;
//     // formData.series = "";
//     // formData.subseries = "";
//     // formData.production_area_id = 0;
//     // formData.start_period = "";
//     // formData.end_period = "";
//     // formData.consecutive_number = "";
// }

function resetForm() {
    Object.assign(formData, initialState);
}

function setForm() {
    Object.assign(dataForm, {
    id: null,    
    background_id: 0,
    section_id: 0,
    series: "",
    subseries: "",
    production_area_id: 0,
    start_period: "",
    end_period: "",
    consecutive_number: "",
    });
}




// ellis85@example.com
</script>
