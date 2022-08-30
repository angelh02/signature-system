<template>
    <table
        id="example"
        class="table table-striped cell-border"
        style="width: 100%"
    ></table>
    <ModalComponent v-show="visible"  @close="close">
    <!-- <template v-slot:header> Cargar expediente </template> -->

    <!-- <template v-slot:body>
      
    </template> -->
    </ModalComponent>
</template>

<script setup>
import { ref, onMounted, watch, toRefs, reactive } from "vue";
import $ from "jquery";
import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, table, row, destroy, draw } from "datatables";
import { useFileClasificationRequests } from "@/js/composables/useFileClasificationRequest.js";
import useFileClasificationRequestsAPI from "@/api/index.js";


const props = defineProps({
    filesClasification: Object,
    updated: Boolean,
});

// const { filesClasification } = toRefs(props)
const { updated } = toRefs(props);
const emit = defineEmits(["data"]);

const filesClasification = ref("");
const name = ref("");
const fila = ref("");
const visible = ref(false);
const refresh = ref(false);
const id = ref("")
const formData = reactive({
    id:"",
    background_id: "",
    section_id: "",
    series: "",
    subseries: "",
    production_area_id: "",
    start_period: "",
    end_period: "",
    consecutive_number: "",
});

const { filesColumns, getClasification } = useFileClasificationRequests();

onMounted(async () => {
    getRequests();
});

const createTable = async () => {
    $("#example").dataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: filesClasification.value,
        columns: filesColumns,
        scrollY: "50vh",
        scrollCollapse: true,
        destroy: true,
    });
    // console.log(filesClasification.value);
    $("#example tbody").on("click", "#btn_editar", function () {
        // fila.value = dtTable.api().row(this).data[0];
        fila.value = $(this).closest("tr");
        let classifications = filesClasification.value;
        let classificationId = parseInt(fila.value.find("td:eq(0)").text());
        let index = classifications.findIndex(x => x.id == classificationId);
        formData.id = classifications[index].id;
        formData.background_id = classifications[index].background_id;
        formData.section_id = classifications[index].section_id;
        formData.series = classifications[index].series;
        formData.subseries = classifications[index].subseries;
        formData.production_area_id = classifications[index].production_area_id;
        formData.start_period = classifications[index].start_period;
        formData.end_period = classifications[index].end_period;
        formData.consecutive_number = classifications[index].consecutive_number;
        emit("data", formData);
        // console.log(formData)
        // console.log(id)
        // openModal();
    });

    $(document).on("click", "#btn_borrar", function(){
        fila.value = $(this);           
        id.value = parseInt($(this).closest('tr').find('td:eq(0)').text());      
        deleteRequests();      
        
    }); 
};

const getRequests = async () => {
    const results = await getClasification([]);
    filesClasification.value = results;
    createTable();
};

const deleteRequests = async () => {
    useFileClasificationRequestsAPI.deleteClassification(id.value)
    .then((res) => {
        // console.log(res)
    });
    $("#example").DataTable().destroy();
    getRequests();
};


watch(
    () => updated,
    (updated, oldUpdated) => {
        $("#example").DataTable().destroy();
        getRequests();
    },
    { deep: true },   
);

const openModal = () => {
    // $("#signup-modal").modal("show")

    visible.value = true;
};

const close = async () => {
    visible.value = false;
    // resetData.value = true;
};
</script>
