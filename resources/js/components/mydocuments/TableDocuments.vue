<template>
<div class="table-responsive">
    <table class="table table-hover table-bordered" id="documentstable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo de documento</th>
                <th>Clasificación</th>
                <th>Contenedor</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="document in documents">
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
                            <a class="dropdown-item" href="#">Descaragar pdf y xml</a>
                            <a class="dropdown-item" href="#">Descaragar pdf</a>
                            <a class="dropdown-item" href="#">Descaragar xml</a>
                        </div>
                    </div> 
                    <a v-if="document.signed == 0" class="btn btn-info " href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Firmar
                    </a>  
                </td>
               
                <td>
                    <div class="dropdown" >
                        <a  class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </a>                                   
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">Ver detalles</a>
                            <a class="dropdown-item" href="#">Ver original</a>
                            <a class="dropdown-item" href="#">Descaragar documento original</a>
                            <a class="dropdown-item" href="#">Eliminar documento</a>
                        </div>
                    </div> 
                </td>
            </tr> 
        </tbody>
    </table>
</div>
    <!-- <table v-if="!documents.value"
        id="example"
        class="table table-striped cell-border"
        style="width: 100%"
    ></table> -->
</template>

<script setup>
import { ref, onMounted, watch, toRefs, reactive, nextTick} from "vue";
import $ from "jquery";
import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, row, destroy, draw } from "datatables";
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentTableRequest.js";
import useFileClasificationRequestsAPI from "@/api/index.js";

const {getDocuments } = useDocumentsRequests();
const documents = ref("")
onMounted(async () => {
    getRequests();
});

const createTable = async () => {
    // $("#example").DataTable({
    //     language: {
    //         url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    //     },
    //     // columns: containerColumns,
    //     scrollY: "45vh",
    //     scrollCollapse: false,
    //     destroy: true
    // });
    await nextTick(function() {
        $("#documentstable").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            },
            scrollCollapse: false,
        });
        
    }); 
}

const getRequests = async (refresh = false) => {
    const results = await getDocuments([]);
    documents.value = results;
    console.log(documents.value)
    var dT = $('#documentstable').DataTable();
    dT.destroy();
    createTable()
    // if(!refresh)
    //     createTable();
    // else
    //     refreshTable();
};
</script>
<style>
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
    -webkit-overflow-scrolling: touch;
        overflow: inherit;

}

</style>