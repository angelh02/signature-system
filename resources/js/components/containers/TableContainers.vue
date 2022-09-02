<template>
    <table
        id="containers_table"
        class="table table-striped cell-border"
        style="width: 100%"
    ></table>
</template>

<script setup>
import { ref, onMounted, watch, toRefs, reactive } from "vue";
import $ from "jquery";
import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, table, row, draw, destroy } from "datatables";
import { useContainersRequests } from "@/js/composables/container-apis/useContainerRequest.js";
import useContainersRequestsAPI from "@/api/container/index.js";


const props = defineProps({
    containersData: Object,
    updated: Boolean,
});

// const { containersData } = toRefs(props)
const { updated } = toRefs(props);
const emit = defineEmits(["data"]);

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

const refreshTable = async() => {
    containerTable.value = $("#containers_table").DataTable({
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
    containerTable.value = $("#containers_table").DataTable({
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

    containerTable.value.on("click", "#btn_borrar", function(){
        fila.value = $(this).closest("tr");      
        const id = parseInt(containerTable.value.rows(fila.value).data()[0].id);   
        deleteRequests(id);      
    });
};

const getRequests = async (refresh = false) => {
    const results = await getContainers([]);
    containersData.value = results;
    if(!refresh)
        createTable();
    else
        refreshTable();
};

const deleteRequests = async (id) => {
    useContainersRequestsAPI.deleteContainer(id)
    .then((res) => {
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

const openModal = () => {
    // $("#signup-modal").modal("show")

    visible.value = true;
};

const close = async () => {
    visible.value = false;
};
</script>