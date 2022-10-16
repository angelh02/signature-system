<template>
<div >
    <table class="table table-striped" id="documentstable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo de documento</th>
                <th>Clasificación</th>
                <th>Contenedor</th>
                <th class="no-sort"></th>
                <th class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="document in filteredDocuments">
                <td>{{document.name}}</td>
                <td>{{document.document_type.name}}</td>
                <td>{{document.classification.name}}</td>
                <td>{{document.container.name}}</td>
                <td>
                    <div class="dropdown" v-if="document.signed == 1">
                        <a  class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Descargar
                        </a>                                   
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <div>
                            <h5 class="dropdown-header col-2">Por cada documento generado 
                            se generan 2 archivos:<br>
                            uno XML y uno PDf asegurate<br> 
                            de descargar ambos</h5>
                            </div>
                            <a class="dropdown-item" href="#" disabled>Descargar pdf y xml</a>
                            <a class="dropdown-item" :href="document?.document_signed?.pdf_url">Descargar pdf</a>
                            <a class="dropdown-item" href="" disabled>Descargar xml</a>
                        </div>
                    </div> 
                    <router-link
                        v-if="document.signed == 0"
                        class="btn btn-primary"
                        :to="`/document/sign/${document?.id}`"
                    >
                        FIRMAR
                    </router-link>
                </td>
                <td>
                    <div class="dropdown" >
                        <a  class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </a>                                   
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <router-link class="dropdown-item" :to="'/document/status/'+document?.id">Ver Detalles</router-link>
                            <!-- <a class="dropdown-item" href="#">Ver original</a> -->
                            <a class="dropdown-item" :href="document?.url">Descargar documento original</a>
                            <a class="dropdown-item" href="#">Eliminar documento</a>
                        </div>
                    </div> 
                </td>
            </tr> 
        </tbody>
    </table>
</div>
</template>

<script setup>
//Libraries
import { ref, onMounted, toRef, watch, toRefs, reactive, nextTick} from "vue";
import $ from "jquery";
import { dataTable, row, destroy, draw } from "datatables";
//Api
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentTableRequest.js";
import useFileClasificationRequestsAPI from "@/api/index.js";

const props = defineProps({
    dataFilter: Object,
});

const dataFilter = toRef(props, "dataFilter");

//Data table
const documentsTable = ref("");

const {getDocuments } = useDocumentsRequests();
const documents = ref("")
const filteredDocuments = ref("");

//Life Cycle
onMounted(async () => {
    getRequests();
});

//Watchs
watch(
    () => dataFilter,
    (dataFilter, olddataFilter) => {
        filterDocuments();
    },
    { deep: true },   
);

//Functions
const createTable = async () => {
    await nextTick(function() {
        documentsTable.value = $("#documentstable").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            },
            scrollCollapse: false,
            columnDefs : [ {
                targets: 'no-sort',
                orderable: false,
            } ],
            destroy : true
        });
    });
}

function filterDocuments(){
    let filters = {};
    for(const [key, value] of Object.entries(dataFilter.value)){
        if(value != "" | value != 0)
            filters[key] = value;
    }
    function filterFun(document){
        let flag = true;       
        for(const [key, value] of Object.entries(filters)){
            if(key == "name")
                flag = flag && document[key].includes(value);
            else
                flag = flag && document[key] == value;
        }
        return flag;
    } 
    if(Object.keys(filters).length > 0)
        filteredDocuments.value = documents.value.filter(filterFun);
    else
        filteredDocuments.value = documents.value;
    documentsTable.value.destroy();
    createTable();
}

const getRequests = async (refresh = false) => {
    const results = await getDocuments([]);
    console.log(results)
    documents.value = results;
    filteredDocuments.value = documents.value;
    createTable();
};
</script>
<style>
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
    -webkit-overflow-scrolling: touch;
        overflow: inherit;

}

</style>