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
import { ref, onMounted, watch, toRefs } from "vue";
import $ from "jquery";
import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, table, row, destroy, draw } from "datatables";
import { useFileClasificationRequests } from "@/js/composables/useFileClasificationRequest.js";

const props = defineProps({
    filesClasification: Object,
    updated: Boolean,
});

// const { filesClasification } = toRefs(props)
const { updated } = toRefs(props);
const emit = defineEmits(["data","id"]);

const filesClasification = ref("");
const name = ref("");
const fila = ref("");
const visible = ref(false);
const refresh = ref("");
const id = ref("")
const formData = ref({
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
    // createTable()

    //  $(document).on("click", ".btnEditar", function(){
    //     // opcion='editar';
    //     fila = $(this);
    //     // fila = $(this).closest("tr");
    //     // id = parseInt(fila.find('td:eq(0)').text());
    //     name = fila.find('td:eq(0)').text();
    //     console.log(name)
    //     // precio = fila.find('td:eq(2)').text();
    //     // stock = fila.find('td:eq(3)').text();
    //     // $("#id").val(id);
    //     // $("#descripcion").val(descripcion);
    //     // $("#precio").val(precio);
    //     // $("#stock").val(stock);
    //     // $(".modal-header").css("background-color", "#7303c0");
    //     // $(".modal-header").css("color", "white" );
    //     // $(".modal-title").text("Editar Artículo");
    //     // $('#modalCRUD').modal('show');
    // });
});

const createTable = async () => {
    let dtTable = $("#example").dataTable({
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
        formData.id = fila.value.find("td:eq(0)").text();
        formData.background_id = fila.value.find("td:eq(1)").text();
        formData.section_id = fila.value.find("td:eq(2)").text();
        formData.series = fila.value.find("td:eq(3)").text();
        formData.subseries = fila.value.find("td:eq(4)").text();
        formData.production_area_id = fila.value.find("td:eq(5)").text();
        formData.start_period = fila.value.find("td:eq(6)").text();
        formData.end_period = fila.value.find("td:eq(7)").text();
        formData.consecutive_number = fila.value.find("td:eq(8)").text();
        emit("data", formData);
        emit("id", id);
        // console.log(formData)
        // console.log(id)
        openModal();
    });

    $(document).on("click", "#btn_borrar", function(){
        fila.value = $(this);           
        id.value = parseInt($(this).closest('tr').find('td:eq(0)').text());            
        
    }); 
};




const getRequests = async () => {
    const results = await getClasification([]);
    filesClasification.value = results;
    refresh.value = filesClasification.value.length;
    createTable();
};

const deleteRequests = async () => {
    const results = await getClasification([]);
    filesClasification.value = results;
    refresh.value = filesClasification.value.length;
    createTable();
};


watch(
    () => updated,
    (updated, oldUpdated) => {
        $("#example").DataTable().destroy();
        getRequests();
    },
    { deep: true }
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
