<template>
    <table
        id="example"
        class="table table-sm table-striped"
        style="width: 100%"
    ></table>
    <ConfirmationModal
        :title="'Confirmacion de Eliminación'"
        :message="'Estas seguro que deseas eliminar ' + tags"
        @response="confirmationResponse"
    ></ConfirmationModal>
</template>

<script setup>
import { ref, onMounted, watch, toRefs, reactive } from "vue";
import $ from "jquery";
import { useRouter, useRoute } from "vue-router";
// import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, table, row, destroy, draw } from "datatables";
import { useCatalogsRequests } from "@/js/composables/admin-apis/useCatalogsRequest.js";
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
import { Modal } from "bootstrap";
//Components
import ConfirmationModal from "../../elements/ConfirmationModal.vue"

const toast = useToast();
const confirmationModal= ref({});
const props = defineProps({
    filesClasification: Object,
    updated: Boolean,
});

const router = useRouter();
const route = useRoute();

// const { filesClasification } = toRefs(props)
const { updated } = toRefs(props);
const emit = defineEmits(["data"]);

const catalogs = ref("");
const catalogsId = ref(0);
const name = ref("");
const fila = ref("");
const tags = ref("");
const visible = ref(false);
const refresh = ref(false);
const formData = reactive({
    id:"",
    name: "",
    code: "",
});

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

const Tag = {
    'tipos-documentos':"el tipo de documento",
    fondos: "el fondo",
    secciones: "la sección",
    'areas-productoras': "el área",
    'tiempos-conservacion':"el tiempo de conservación",
    'tipos-conservacion':"el tipo de conservación",
    'valores-documentales':"el valor documental",
    'tipos-informacion':"tipo de información",
    'tecnicas-seleccion':"la tecnica de selección"
}

function confirmationResponse(response){
    confirmationModal.value.hide();
    if(response)
        deleteRequests(catalogsId.value);
}

const globalTable = ref("");

const { catalogsColumns } = useCatalogsRequests();


onMounted(async () => {
    getRequests();
});

const refreshTable = async() => {
    globalTable.value = $("#example").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: catalogs.value,
        columns: catalogsColumns,
        scrollY: "50vh",
        scrollCollapse: true,
        destroy: true,
    });
}

const createTable = async () => {
    globalTable.value = $("#example").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: catalogs.value,
        columns: catalogsColumns,
        scrollY: "50vh",
        scrollCollapse: true,
        destroy: true,
    });
    globalTable.value.on("click", "#btn_editar", function () {
        fila.value = $(this).closest("tr");
        let catalog = catalogs.value;
        let catalogsId = parseInt(globalTable.value.rows(fila.value).data()[0].id);
        let index = catalog.findIndex(x => x.id == catalogsId);
        formData.id = catalog[index].id;
        formData.name = catalog[index].name;
        formData.code = catalog[index].code;
        emit("data", formData);
      
    });

    /* globalTable.value.on("click", "#btn_borrar", function(){
        fila.value = $(this).closest("tr");           
        const id = parseInt(globalTable.value.rows(fila.value).data()[0].id); 
        catalogsId.value = id;
        confirmationModal.value.show();
        // deleteRequests(id);      
    }); */ 
};

const getRequests = async (refresh = false) => {
    tags.value = Tag[route.params.name]
    const get = apisGet[route.params.name]
    const info = await get.getAll([]);
    catalogs.value = info;
    confirmationModal.value = new Modal($("#confirmation-modal"))
    if(!refresh)
        createTable();
    else
        refreshTable();
};

const deleteRequests = async (id) => {
    const get = apisGet[route.params.name]
    get.drop(id)
    .then((res) => {
        toast.success("Se ha eliminado el folio "+ id + " correctamente", {
          timeout: 2000,
        });
        getRequests(true);
    });
   
};


watch(
    () => updated,
    (updated, oldUpdated) => {
        getRequests(true);
    },
    { deep: true },    
);

watch(  
    () => route.params.name,
    (route, oldRoute) => {
        getRequests(true);
    },
    { deep: true },
);

</script>