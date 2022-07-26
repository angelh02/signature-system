<template>
<div >
    <table class="table table-sm table-striped" id="my-documents-table" cellspacing="0" style="width:100%">
        <thead>
            <tr>
                <th data-priority="1">Nombre</th>
                <th>Tipo de documento</th>
                <th>Clasificación</th>
                <th>Contenedor</th>
                <th class="no-sort"></th>
                <th class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="document in filteredDocuments">
                <td>
                    <p class="m-0">
                        <span style="font-size: 3pt;" :class="'align-middle badge border border-light rounded-circle p-1 bg-'+(document.signed == 0 || !checkDocumentSigned(document.aws_document_id) ? 'warning' : 'success') ">
                            &nbsp;&nbsp;&nbsp;
                        </span>
                        <span class="align-middle ms-1">{{document.name}}</span>
                    </p>
                </td>
                <td>{{document.document_type.name}}</td>
                <td>{{document.classification.name}}</td>
                <td>{{document.container.name}}</td>
                <td>
                    <div class="dropdown" v-if="document.signed == 1 && checkDocumentSigned(document.aws_document_id)">
                        <a  class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            DESCARGAR
                        </a>                                   
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <div>
                            <h5 class="dropdown-header col-2" v-if="false">Por cada documento generado 
                            se generan 2 archivos:<br>
                            un pdf firmado electronicamente<br> 
                            y otro para su impresión</h5>
                            </div>
                            <a v-if="false" class="dropdown-item" type="button" @click="viewSignedDocument(document?.aws_document_id)">Descargar pdf</a>
                            <a class="dropdown-item" type="button" @click="viewPrintDocument(document?.aws_document_id)" disabled>Descargar PDF</a>
                        </div>
                    </div> 
                    <button 
                        v-if="document.document_signers.length > 0 && document.document_signers[0].signed == 0"
                        @click="singDocument(document.id)" class="btn btn-sm btn-primary">
                        FIRMAR
                    </button>
                </td>
                <td>
                    <div class="dropdown" >
                        <a  class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </a>                                   
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <router-link class="dropdown-item" :to="'/mis-documentos/detalles/'+document?.id" v-if="(document?.signed == 1 && checkDocumentSigned(document?.aws_document_id)) || document?.signed == 0">Ver Detalles</router-link>
                            <!-- <a class="dropdown-item" href="#">Ver original</a> -->
                            <a class="dropdown-item" type="button" @click="viewDocument(document?.aws_document_id)">Descargar documento original</a>
                            <a v-if="document.user_id == userLogged.id && document.signed == 0" class="dropdown-item" @click="deleteDocument(document.id)">Cancelar documento</a>
                            <a v-if="document.user_id == userLogged.id && document.signed == 1 && document.deletion_requests.length == 0" class="dropdown-item" @click="openDeletionRequest(document.id)">Cancelar documento</a>
                        </div>
                    </div> 
                </td>
            </tr> 
        </tbody>
    </table>
    <CreateDeletionRequestModal
        :document-id="documentIdSelected"
        @cancel="cancelDeletionRequest"
        @stored="storedDeletionRequest"
    >
    </CreateDeletionRequestModal>
    <ConfirmationModal
        :title="'Confirmación de cancelación'"
        :message="'Éstas seguro de cancelar el siguiente documento'"
        @response="confirmationResponse"
    ></ConfirmationModal>
</div>
</template>

<script setup>
//Components
import CreateDeletionRequestModal from "./CreateDeletionRequestModal.vue";
import ConfirmationModal from "../elements/ConfirmationModal.vue";
//Libraries
import { ref, onMounted, toRef, watch, toRefs, reactive, nextTick} from "vue";
import $ from "jquery";
import { Modal } from "bootstrap";
import { dataTable, row, destroy, draw } from "datatables";
import {useToast} from "vue-toastification";
import { useRouter } from "vue-router";
//Api
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentTableRequest.js";
import useDocumentCrudRequests from "@/api/document/index.js";
import useFileClasificationRequestsAPI from "@/api/index.js";
import useSignRequestsAPI from "@/api/sign-document/index.js";

const toast = useToast();

const router = useRouter();

const emit = defineEmits(['refresh'])

const props = defineProps({
    signedDocuments : Array,
    dataFilter: Object,
    needSign: Boolean,
    userLogged: Object,
    refresh: Boolean,
    reload: Boolean
});

const signedDocuments = toRef(props, "signedDocuments");
const dataFilter = toRef(props, "dataFilter");
const needSign = toRef(props, "needSign");
const userLogged = toRef(props, "userLogged");
const refresh = toRef(props, "refresh");
const reload = toRef(props, "reload");

//Data table
const documentsSignTable = ref("");

const deletionRequestModal = ref({});
const confirmationModal= ref({});
const documentIdSelected = ref(0);

const {getDocuments, getUserDocuments} = useDocumentsRequests();
const documents = ref("")
const filteredDocuments = ref("");

defineExpose({
  filteredDocuments
})

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
watch(
    () => refresh,
    (refresh, oldRefresh) => {
        documentsSignTable.value.destroy();
        getRequests(true);
    },
    { deep: true },   
);
watch(
    () => needSign,
    (needSign, oldNeedSign) => {
        filterDocuments();
    },
    { deep: true },   
);
watch(
    () => reload,
    (reload, oldReload) => {
        documentsSignTable.value.destroy();
        createTable();
    },
    { deep: true },   
);

//Functions
function cancelDeletionRequest(){
    deletionRequestModal.value.hide();
}

function confirmationResponse(response){
    confirmationModal.value.hide();
    if(response)
        deleteRequests(documentIdSelected.value);
}

const createTable = async () => {
    await nextTick(function() {
        documentsSignTable.value = $("#my-documents-table").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            },
            bFilter: false,
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
}

function checkDocumentSigned(awsDocumentId){
    if(signedDocuments.value.length > 0){
        return signedDocuments.value.findIndex(x => x.id == awsDocumentId && x.status == "Signed") != -1;
    }
    return false;
}

function deleteRequests(){
    useDocumentCrudRequests.deleteDocument(documentIdSelected.value)
    .then((res) => {
        //console.log(res);
        toast.success("Se elimino el documento correctamente", {
            timeout: 2000,
        });
        emit('refresh');
    })
    .catch(e => {
        console.log(e);
        toast.warning("No se ha podido cancelar el documento", {
            timeout: 2000,
        })
    });
}

function deleteDocument(documentId){
    documentIdSelected.value = documentId;
    confirmationModal.value.show();
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
    if(needSign.value)
        filteredDocuments.value = filteredDocuments.value.filter(x => x.document_signers.length > 0 && x.document_signers[0].signed == 0 && x.document_signers[0].signed_at == null)
    documentsSignTable.value.destroy();
    createTable();
}

const getRequests = async (refresh = false) => {
    const results = await getUserDocuments(userLogged.value.id);
    documents.value = results;
    filteredDocuments.value = documents.value;
    if(refresh && (Object.keys(dataFilter.value).length > 0 || needSign.value))
        filterDocuments();
    else
        createTable();
    deletionRequestModal.value = new Modal($("#deletion-request-modal"))
    confirmationModal.value = new Modal($("#confirmation-modal"))
};

function singDocument(documentId){
    let ids = JSON.stringify({documents : [documentId]});
    router.push({
        name : 'DocumentSign',
        params: {ids: ids}
    });
}

function storedDeletionRequest(){
    deletionRequestModal.value.hide();
    emit('refresh');
}

function openDeletionRequest(documentId){
    documentIdSelected.value = documentId;
    deletionRequestModal.value.show();
}

async function viewDocument(documentId){
    let url = await useSignRequestsAPI.getDocumentBase(documentId, userLogged.value.aws_auth_token);
    window.open(url, '_blank');
}

async function viewPrintDocument(documentId){
    let url = await useSignRequestsAPI.getPrintDocument(documentId, userLogged.value.aws_auth_token);
    window.open(url, '_blank');
}

async function viewSignedDocument(documentId){
    let url = await useSignRequestsAPI.getDocumentSigned(documentId, userLogged.value.aws_auth_token);
    window.open(url, '_blank');
}
</script>
<style>
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
    -webkit-overflow-scrolling: touch;
        overflow: inherit;

}

</style>