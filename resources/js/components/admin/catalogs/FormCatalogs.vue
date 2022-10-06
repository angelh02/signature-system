<template>
    <div class="card-title">
        <h4>Agregar nueva clasificación</h4>
    </div>
    <form class="needs-validation" @submit.prevent="onSubmit" novalidate>
        <div class="mb-3">
            <label class="form-label"
                >Codigo</label
            >
            <input
                type="text"
                class="form-control"
                id="code"
                placeholder="Ingrese"
                minlength="1"
                maxlength="10"
                v-model="formData.code"
                required
            />
            <div class="invalid-feedback">Please provide a valid zip.</div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >Nombre</label
            >
            <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Ingrese"
                minlength="5"
                maxlength="255"
                v-model="formData.name"
                required
            />
            <div class="invalid-feedback">Please provide a valid zip.</div>
        </div>
        <div class="row justify-items-center">
            <button v-if="!edit" class="btn btn-primary mb-2" type="submit" @click.prevent="addClassification">
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
import { ref, toRef, onMounted, reactive} from 'vue';
import { useRouter, useRoute } from "vue-router";
import $ from "jquery";

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

const formData = reactive(dataForm);


// const formData = ref(
//     {
//         code: "",
//         name: ""
//     }
// )

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

const onSubmit = async (values) => {
    // alert("yep")
    // submit.value = true
    // if($v.$invalid){
    //     return;
    // }
};

onMounted(async () => {
    await getRequests();
});

const addClassification = async () => {
    const get = apisGet[route.params.name]
    get.store(formData.value)
    .then((res) => {
        toast.success("Se ha agragado corectamente", {
          timeout: 2000,
        });
    })
    .catch(error => 
        toast.warning("No se ha posido Agregar", {
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
    formData.value.code = "";
    emit('cancel');
}


const getRequests = async () => {
    const resBackground =  await useFileCatalogsBackgroundAPI.getAll("");
    backGround.value = resBackground;

    const resSection = await useFileCatalogsProductionAPI.getAll("");
    productionArea.value = resSection;

    const resProductionArea = await useFileCatalogsSectionAPI.getAll("");
    section.value = resProductionArea;

}





</script>