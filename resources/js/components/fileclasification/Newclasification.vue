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
                <div class="input-group date" >
                    <input
                        autocomplete="off"
                        type="text"
                        class="form-control"
                        data-date-autoclose="true"
                        v-model="formData.end_period"
                        id="end_period"
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
            <button class="btn btn-light mb-2" type="submit" @click="resetData">CANCELAR</button>
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

const onSubmit = async (values) => {
    // alert("yep")
    // submit.value = true
    // if($v.$invalid){
    //     return;
    // }
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
    useFileClasificationRequestsAPI.addClassification(formData.value)
    .then((res) => {
    });
    emit('update');
    onSubmit()
};

const editRequest = async => {
    onSubmit()
   
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
    


}

function resetData(){
    formData.value.id = null;
    formData.value.background_id = 0;
    formData.value.section_id = 0;
    formData.value.series = "";
    formData.value.subseries = "";
    formData.value.production_area_id = 0;
    formData.value.start_period = "";
    formData.value.end_period = "";
    formData.value.consecutive_number = "";
    emit('cancel');
}
</script>
