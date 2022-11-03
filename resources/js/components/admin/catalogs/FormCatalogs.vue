<template>
    <div v-if="route.params.name === 'tipos-documentos'">
        <h4 v-if="!edit">Agregar nuevo tipo de documento</h4>
        <h4 v-if="edit">Editar tipo de documento</h4>
    </div>
    <div v-else class="card-title">
        <div v-if="!edit" class="d-flex">
            <h4 v-if="!edit">Agregar nuev@ (</h4><h4 class="text-lowercase">{{btn}})</h4>
        </div>
        <div v-if="edit" class="d-flex">
            <h4 v-if="edit">Editar (</h4><h4 class="text-lowercase"> {{ btn}})</h4>
        </div>
        
    </div>
    <form class="needs-validation" @submit.prevent="onSubmit" novalidate>
        <div class="mb-3">
            <label class="form-label"
                >Codigo</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="text"
                    class="form-control"
                    id="code"
                    placeholder="Ingrese"
                    minlength="1"
                    maxlength="10"
                    v-model="v$.code.$model"
                    required
                />
                <div v-for="(error, index) in v$.code.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >Nombre</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Ingrese"
                    minlength="5"
                    maxlength="255"
                    v-model="v$.name.$model"
                    required
                />
                <div v-for="(error, index) in v$.name.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="row justify-items-center">
            <button v-if="!edit" class="btn btn-primary mb-2" type="submit" @click.prevent="addClassification" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">
                AGREGAR {{btn}}
            </button>
            <button v-if="edit" class="btn btn-primary mb-2" type="submit" @click.prevent="editRequest" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">
                ACTUALIZAR {{btn}}
            </button>
            <button class="btn btn-light mb-2" type="submit" @click="resetData()">CANCELAR</button>
        </div>
    </form>
</template>

<script setup>
import { ref, toRef, onMounted, reactive, watch} from 'vue';
import { useRouter, useRoute } from "vue-router";
import $ from "jquery";
import { useVuelidate } from '@vuelidate/core'
import { required, email ,minValue, helpers, minLength, maxLength} from '@vuelidate/validators'

// clasificaciones
import useFileCatalogsBackgroundAPI from "@/api/admin/catalogs/classification/background.js";
import useFileCatalogsProductionAPI from "@/api/admin/catalogs/classification/production-area.js";
import useFileCatalogsSectionAPI from "@/api/admin/catalogs/classification/section.js";
// contenedores
import useFileCatalogsTimeAPI from "@/api/admin/catalogs/container/conservation-time.js";
import useFileCatalogsTypeAPI from "@/api/admin/catalogs/container/conservation-type.js";
import useFileCatalogsValueAPI from "@/api/admin/catalogs/container/document-value.js";
import useFileCatalogsInfoAPI from "@/api/admin/catalogs/container/information-type.js";
import useFileCatalogsSelectionAPI from "@/api/admin/catalogs/container/selection-technique.js";
// tipos de documentos
import useFileCatalogsDocumentAPI from "@/api/admin/catalogs/document-type.js";
import {useToast} from "vue-toastification";

const toast = useToast();
const router = useRouter();
const route = useRoute();
const emit = defineEmits(['update','cancel'])

const props = defineProps({
    dataForm: Object,
    edit: Boolean,
    param: String
});

//ReadOnly
const dataForm = toRef(props, 'dataForm');
const edit = toRef(props, 'edit');
const param = toRef(props, 'param');
const productionArea = ref([]);
const section = ref("");
const backGround = ref("");
const btn = ref("")
const formData = reactive(dataForm);

const showAll = ref(false);
    const rules = {
      code: {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        minLength: helpers.withMessage('Minimo debe ser un caracter', minLength(0)),
        maxLength: helpers.withMessage('Maximo debe ser 10 caracteres', maxLength(10)),
      },
      name: {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        minLength: helpers.withMessage('Minimo debe ser 5 caracteres', minLength(5)),
        maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
      },
    };
    const state = reactive(dataForm);

const v$ = useVuelidate(rules, formData);
 


const apisGet = {
    'tipos-documentos':useFileCatalogsDocumentAPI,
    fondos: useFileCatalogsBackgroundAPI,
    secciones: useFileCatalogsSectionAPI,
    'areas-productoras': useFileCatalogsProductionAPI,
    'tiempos-conservacion':useFileCatalogsTimeAPI,
    'tipos-conservacion':useFileCatalogsTypeAPI,
    'valores-documentales':useFileCatalogsValueAPI,
    'tipos-informacion':useFileCatalogsInfoAPI,
    'tecnicas-seleccion':useFileCatalogsSelectionAPI
}

const buttonTag = {
    'tipos-documentos':"NUEVO DOCUMENTO",
    fondos: "FONDO",
    secciones: "SECCIÓN",
    'areas-productoras': "NUEVA ARÉA",
    'tiempos-conservacion':"NUEVO TIEMPO",
    'tipos-conservacion':"NUEVA CONSERVACIÓN",
    'valores-documentales':"VALOR",
    'tipos-informacion':"NUEVA INFORMACIÓN",
    'tecnicas-seleccion':"TECNICA"
}


const onSubmit = async (values) => {
    // if(v$.$invalid){
    //     console.log("Es invalido");
    //     return
        
    // }
   
};

onMounted(async () => {
    await getRequests();
});

const addClassification = async () => {
    onSubmit();
    const get = apisGet[route.params.name]
    get.store(formData.value)
    .then((res) => {
        toast.success("Se ha agregado correctamente", {
          timeout: 2000,
        });
    })
    .catch(error => 
        toast.warning("No se ha podido agregar", {
          timeout: 2000,
        })
    );
    emit('update');
    resetData();
    onSubmit();
};

const editRequest = async => {
    onSubmit()
    const get = apisGet[route.params.name]
    get.update(formData.value)
    .then((res) => {
        toast.success("El registro se ha actualizado correctamente", {
          timeout: 2000,
        })
    })
    .catch((error) =>{
        toast.error("El registro no se ha actualizado", {
          timeout: 2000,
        });
    });
    emit('update');
    resetData();
}

function resetData(){
    v$._value.$reset();
    emit('cancel');
}


const getRequests = async () => {
    btn.value = buttonTag[route.params.name]

    const resBackground =  await useFileCatalogsBackgroundAPI.getAll("");
    backGround.value = resBackground;

    const resSection = await useFileCatalogsProductionAPI.getAll("");
    productionArea.value = resSection;

    const resProductionArea = await useFileCatalogsSectionAPI.getAll("");
    section.value = resProductionArea;

};

watch(  
    () => route.params.name,
    (route, oldRoute) => {
        getRequests();
    },
    { deep: true },
);


</script>