<template>
    <table
        id="classification-table"
        class="table table-striped cell-border"
        cellspacing="0" style="width:100%"
    >
        <thead>
            <tr>
                <th data-priority="1">Clasificación</th>
                <th>Fondo</th>
                <th>Sección</th>
                <th>Area de producción</th>
                <th class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="fileClassification in filesClasification">
                <td>{{fileClassification.name}}</td>
                <td>{{fileClassification.background.code}}</td>
                <td>{{fileClassification.section.name}}</td>
                <td>{{fileClassification.production_area.code}}</td>
                <td>
                    <button id="btn_editar" class="btn btn-warning uil-edit-alt" @click="updateClassification(fileClassification.id)"></button>
                </td>
            </tr> 
        </tbody>
    </table>
    <ConfirmationModal
        :title="'Confirmación de Eliminación'"
        :message="'Éstas seguro de eliminar el siguiente registro, esto hara que se eliminen los documentos referenciados a esta clasificación'"
        @response="confirmationResponse"
    ></ConfirmationModal>
</template>

<script setup>
//Libraries
import { ref, onMounted, watch, toRefs, reactive, nextTick } from "vue";
import $ from "jquery";
import { Modal } from "bootstrap";
import { dataTable, table, row, destroy, draw} from "datatables";
//Components
import ConfirmationModal from '../elements/ConfirmationModal.vue';
//Api functions
import { useFileClasificationRequests } from "@/js/composables/useFileClasificationRequest.js";
import useFileClasificationRequestsAPI from "@/api/index.js";


const props = defineProps({
    filesClasification: Object,
    updated: Boolean,
});

// const { filesClasification } = toRefs(props)
const { updated } = toRefs(props);
const emit = defineEmits(["data"]);

//Modal const
const confirmationModal = ref({});
const classificationId = ref(0);

const filesClasification = ref("");
const name = ref("");
const fila = ref("");
const visible = ref(false);
const refresh = ref(false);
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
const classificationTable = ref("");

const { filesColumns, getClasification } = useFileClasificationRequests();

onMounted(async () => {
    getRequests();
});

function confirmationResponse(response){
    confirmationModal.value.hide();
    if(response)
        deleteRequests(classificationId.value);
}

const refreshTable = async() => {
    classificationTable.value = $("#classification-table").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        scrollY: "600px",
        scrollCollapse: false,
        responsive: true,
        columnDefs : [ {
            targets: 'no-sort',
            orderable: false,
        },{ width: '30%', targets: 0 }
        ],
        fixedColumns: true,
        destroy : true
    });
}

const createTable = async () => {
    await nextTick(function() {
        classificationTable.value = $("#classification-table").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            },
            scrollY: "600px",
            scrollCollapse: false,
            responsive: true,
            columnDefs : [ {
                targets: 'no-sort',
                orderable: false,
            },{ width: '30%', targets: 0 }
            ],
            fixedColumns: true,
            destroy : true
        });
    });
    /* classificationTable.value.on("click", "#btn_editar", function () {
        fila.value = $(this).closest("tr");
        let classifications = filesClasification.value;
        let classificationId = parseInt(classificationTable.value.rows(fila.value).data()[0].id);
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
    }); */

    /* classificationTable.value.on("click", "#btn_borrar", function(){
        fila.value = $(this).closest("tr");      
        const id = parseInt(classificationTable.value.rows(fila.value).data()[0].id);   
        classificationId.value = id;
        confirmationModal.value.show();      
    });  */
};

const getRequests = async (refresh = false) => {
    const results = await getClasification([]);
    filesClasification.value = results;
    if(!refresh){
        confirmationModal.value = new Modal("#confirmation-modal");
        createTable();
    }
    else{
        classificationTable.value.destroy();
        createTable();
    }
};

const deleteRequests = async (id) => {
    useFileClasificationRequestsAPI.deleteClassification(id)
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

function updateClassification(classificationId){
    let classifications = filesClasification.value;
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
}

watch(
    () => updated,
    (updated, oldUpdated) => {
        getRequests(true);
    },
    { deep: true },   
);
</script>
