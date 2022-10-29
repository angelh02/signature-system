<template>
    <div v-if="!showPrepa" class="px-4">
        <div>
            <DocumentSearch
                @filterData="filterData"
                :classifications="classifications"
                :containers="containers"
                :documentTypes="documentTypes"
            ></DocumentSearch>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <h4 class="m-0">Documentos</h4>
            <p class="m-0">
                <span class="align-middle me-2">Estado del documento: </span>
                <span style="font-size: 3pt;" class="align-middle badge border border-light rounded-circle p-1 bg-warning">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </span>
                <span class="align-middle ms-1 me-2">Pendiente</span>
                <span style="font-size: 3pt;" class="align-middle badge border border-light rounded-circle p-1 bg-success">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </span>
                <span class="align-middle ms-1">Firmado</span>
            </p>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <div class="dropzone" v-bind="getRootProps()">
                            <div class="dz-message needsclick row align-items-center">
                                <input v-bind="getInputProps()" accept="application/pdf"/>
                                <h4 class="text-muted mdi mdi-file-upload-outline">
                                    Arrastra tu documetos a la página o
                                    <label
                                        ><a class="text-primary"
                                            >click aquí para seleccionar uno</a
                                        ></label
                                    >
                                    <input class="dropzoneFile btn-check" />
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">           
                <div class="card card-h-100">
                    <ul class="nav nav-tabs ps-2 mt-2 mb-0">
                        <li class="nav-item">
                            <a href="#user-documents" data-bs-toggle="tab" aria-expanded="false" class="nav-link active" @click="selectedTable='my-documents'">
                                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                <span class="d-none d-md-block">Mis Documentos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#sign-documents" data-bs-toggle="tab" aria-expanded="true" class="nav-link" @click="selectedTable='sign-documents'">
                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                <span class="d-none d-md-block">Documentos a Firmar</span>
                            </a>
                        </li>
                        <li class="ms-auto me-2 d-flex align-items-center">
                            <button
                                class="btn btn-sm btn-primary me-2 mb-1"
                                type="button"
                                @click="signAllDocuments"
                                :disabled="!needSign"
                            >
                                FIRMAR TODOS
                            </button>
                            <p class="mb-1 me-2"><b>Documentos que requiren mi firma</b></p>
                            <div>
                                <input type="checkbox" id="signed_switch" data-switch="primary" v-model="needSign"/>
                                <label for="signed_switch" data-on-label="SI" data-off-label="NO"></label>
                            </div>
                        </li>
                    </ul>
                    <div>
                        
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="user-documents">
                                <TableDocuments ref="tableDocuments" :dataFilter="dataFilter" :userLogged="userLogged" :needSign="needSign" :refresh="refreshTable" :reload="reloadTable" @refresh="refreshTables"></TableDocuments>
                            </div>
                            <div class="tab-pane" id="sign-documents">
                                <TableDocumentsSign ref="tableDocumentsSign" :dataFilter="dataFilter" :userLogged="userLogged" :needSign="needSign" :refresh="refreshTable" :reload="reloadTable" @refresh="refreshTables"></TableDocumentsSign>
                            </div>
                        </div>
                        <!-- <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        Property HY1xx is not receiving hits. Either your site is not receiving any sessions or it is not tagged correctly.
                    </div> -->
                    </div>
                </div>
            </div>
        </div>
        <CreateDocumentModal
            @cancel="cancelCreation"
            @preparation="documentsPreparation"
            :classifications="classifications"
            :dataFiles="dataFiles"
            :containers="containers"
            :documentTypes="documentTypes"
        ></CreateDocumentModal>
    </div>
</template>

<script setup>
//Components
import DocumentUpload from "../elements/DropZone.vue";
import DocumentSearch from "./DocumentSearch.vue";
import TableDocuments from "../mydocuments/TableDocuments.vue";
import TableDocumentsSign from "../mydocuments/TableDocumentsSign.vue";
import CreateDocumentModal from "./CreateDocumentModal.vue";
//Libraries
import $ from "jquery";
import { Modal } from "bootstrap";
import { onMounted, ref, reactive, toRef, watch } from "vue";
import { useDropzone } from "vue3-dropzone";
import { useRouter } from "vue-router";
//Apis
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentsRequest.js";

const props = defineProps({
    user: Object
});

const userLogged = toRef(props, 'user');
//Consts to use api functions
const { getDocumentsType, getClasification,getContainers } =
    useDocumentsRequests();

//Consts to use dropezone functions
const { getRootProps, getInputProps, ...rest } = useDropzone({
    onDrop,
    onDropAccepted,
});


const documentModal = ref({});
const router = useRouter();

const emit = defineEmits(["data"]);
const showModal = ref(false);
const classifications = ref({});
const containers = ref({});
const documentTypes = ref({});
const showPrepa = ref("");
const resFiles = ref("");

// varible para filtros
const  dataFilter =  ref({});
const  needSign = ref(false);
const refreshTable = ref(false);
const reloadTable = ref(false);
const selectedTable = ref('mi-documents');

//tables
const tableDocuments = ref(null);
const tableDocumentsSign = ref(null);

//Life Cycle
onMounted(async () => {
    await getRequests();
});
//watches
watch(
    () => selectedTable,
    (selectedTable, oldSelectedTable) => {
        reloadTable.value = !reloadTable.value;
    },
    {deep : true}
);

//Functions
function cancelCreation(){
    documentModal.value.hide();
}

function documentsPreparation(newFiles){
    console.log("🚀 ~ file: Documents.vue ~ line 181 ~ documentsPreparation ~ newFiles", newFiles.value)
    documentModal.value.hide();
    router.push({
        name : 'DocumentsPreparation',
        params: {files: newFiles}
    });
}

const getRequests = async () => {
    const resdocumentType = await getDocumentsType("");
    documentTypes.value = resdocumentType;

    const resClasification = await getClasification("");
    classifications.value = resClasification;

    const resContainer = await getContainers("");
    containers.value = resContainer;

    showModal.value = true;
    documentModal.value = new Modal($("#create-modal"));
};

const dataFiles = ref({});
const shadow = ref(false);
const url = "{your_url}"; // Your url on the server side
const saveFiles = (files) => {
    const formData = new FormData();
    for (var x = 0; x < files.length; x++) {
        formData.append("images[]", files[x]);
    }
};

function onDrop(acceptFiles, rejectReasons) {
    saveFiles(acceptFiles);
}

function filterData(filterData) {
    dataFilter.value = filterData;
}

function showPreparation(data) {
    showPrepa.value = data;
}

function resFile(resFile) {
    resFiles.value = resFile;
}

function onDropAccepted(acceptFiles) {
    saveFiles(acceptFiles);
    var encoded = btoa(JSON.stringify(acceptFiles))
    var actual = JSON.parse(atob(encoded))
    dataFiles.value = acceptFiles;
    documentModal.value.show();
}

function refreshTables(){
    refreshTable.value = !refreshTable.value;
}

function signAllDocuments(){
    let documentsToSign = selectedTable.value == "my-documents" ? tableDocuments.value.filteredDocuments : tableDocumentsSign.value.filteredDocuments;
    //Router push
    let ids = JSON.stringify(documentsToSign.map(x => x.id));
    console.log("🚀 ~ file: DocumentsPreparation.vue ~ line 398 ~ .then ~ ids", ids)
    /* router.push({
        name : 'DocumentSign',
        params: {ids: ids}
    }); */
}
</script>
