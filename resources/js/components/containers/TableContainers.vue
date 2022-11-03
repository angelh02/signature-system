<template>
    <table
        id="containers-table"
        class="table table-striped cell-border"
        style="width: 100%"
    ></table>
    <ConfirmationModal
        :title="'Confirmacion de Eliminación'"
        :message="'Estas seguro de eliminar el siguiente registro, esto hara que se eliminen los documentos referenciados a este contenedor'"
        @response="confirmationResponse"
    ></ConfirmationModal>
</template>

<script setup>
//Libraries
import { ref, onMounted, watch, toRefs, reactive } from "vue";
import $ from "jquery";
import { Modal } from "bootstrap";
import { dataTable, table, row, draw, destroy } from "datatables";
import { useToast } from "vue-toastification";
//Components
import ConfirmationModal from '../elements/ConfirmationModal.vue';
//Api functions
import { useContainersRequests } from "@/js/composables/container-apis/useContainerRequest.js";
import useContainersRequestsAPI from "@/api/container/index.js";

const toast = useToast();
const props = defineProps({
    containersData: Object,
    updated: Boolean,
});

// const { containersData } = toRefs(props)
const { updated } = toRefs(props);
const emit = defineEmits(["data"]);

//Modal const
const confirmationModal = ref({});
const containerId = ref(0);

const containersData = ref("");
const name = ref("");
const fila = ref("");
const visible = ref(false);
const refresh = ref(false);
const formData = reactive({
    id:"",
    conservation_time_id: 0,
    conservation_type_id: 0,
    document_value_id: 0,
    information_type_id: 0,
    selection_technique_id: 0,
    effective_date: "",
});
const containerTable = ref("");

const { containerColumns, getContainers } = useContainersRequests();

onMounted(async () => {
    getRequests();
});

function confirmationResponse(response){
    confirmationModal.value.hide();
    if(response)
        deleteRequests(containerId.value);
}

const refreshTable = async() => {
    containerTable.value = $("#containers-table").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: containersData.value,
        columns: containerColumns,
        scrollY: "50vh",
        scrollCollapse: true,
        destroy: true,
    });
}

const createTable = async () => {
    containerTable.value = $("#containers-table").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: containersData.value,
        columns: containerColumns,
        scrollY: "50vh",
        scrollCollapse: true,
        destroy: true,
        
    });
    containerTable.value.on("click", "#btn_editar", function () {
        fila.value = $(this).closest("tr");
        let containers = containersData.value;
        let containerId = parseInt(containerTable.value.rows(fila.value).data()[0].id);
        let index = containers.findIndex(x => x.id == containerId);
        formData.id = containers[index].id;
        formData.name = containers[index].name;        
        formData.conservation_time_id = containers[index].conservation_time_id;
        formData.conservation_type_id = containers[index].conservation_type_id;
        formData.document_value_id = containers[index].document_value_id;
        formData.information_type_id = containers[index].information_type_id;
        formData.selection_technique_id = containers[index].selection_technique_id;
        formData.effective_date = containers[index].effective_date;
        emit("data", formData);
    });

    /* containerTable.value.on("click", "#btn_borrar", function(){
        fila.value = $(this).closest("tr");      
        const id = parseInt(containerTable.value.rows(fila.value).data()[0].id);   
        containerId.value = id;
        confirmationModal.value.show();      
    }); */
};

const getRequests = async (refresh = false) => {
    const results = await getContainers([]);
    containersData.value = results;
    confirmationModal.value = new Modal("#confirmation-modal")
    if(!refresh)
        createTable();
    else
        refreshTable();
};

const deleteRequests = async (id) => {
    useContainersRequestsAPI.deleteContainer(id)
    .then((res) => {
        toast.success("Se ha eliminado correctamente el contenedor", {
            timeout: 2000,
            });
        getRequests(true);
    })
    .catch(error => 
        toast.error("No se ha podido eliminar", {
        timeout: 2000,
        })
    );
};


watch(
    () => updated,
    (updated, oldUpdated) => {
        getRequests(true);
    },
    { deep: true },   
);
</script>