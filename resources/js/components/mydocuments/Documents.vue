<template>
    <div v-if="!showPrepa" class="px-4">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h1 class="page-title">
                        Prepara un documento para ser firmado
                    </h1>
                </div>
            </div>
        </div>
        <div>
            <div class="dropzone" v-bind="getRootProps()">
                <div class="dz-message needsclick row align-items-center">
                    <input v-bind="getInputProps()" />
                    <h4 class="h3 text-muted mdi mdi-file-upload-outline">
                        Arrastra tu documetos a la página o
                        <label
                            ><a class="text-info"
                                >click aquí para seleccionar uno</a
                            ></label
                        >
                        <input class="dropzoneFile btn-check" />
                    </h4>
                </div>
            </div>
        </div>
        <!-- <DocumentUpload
            @drop.prevent="drop"
            @change="selectedFile"
        ></DocumentUpload>
        <div v-if="dropzoneFile.name != null">
            <div class="card mt-1 mb-0 shadow-none border">
                <div class="p-2">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="mdi h1 mdi-file-pdf"></i>
                        </div>
                        <div class="col ps-0">
                            <a
                                href="javascript:void(0);"
                                class="text-muted fw-bold"
                                data-dz-name
                                >{{ dropzoneFile }}</a
                            >
                            <p class="mb-0" data-dz-size></p>
                        </div>
                        <div class="col-auto">
                            <a
                                href=""
                                class="btn btn-link btn-lg text-muted"
                                data-dz-remove
                            >
                                <i class="dripicons-cross"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else></div> -->
        <div class="mt-3">
            <h5>Filtros rapidos</h5>
            <hr />
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <DocumentSearch
                            @clasification="clasificationData"
                            @container="containerData"
                            @typeDocument="typeDocumentData"
                        ></DocumentSearch>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="card card-h-100">
                    <div class="card-body">
                        <!-- <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        Property HY1xx is not receiving hits. Either your site is not receiving any sessions or it is not tagged correctly.
                    </div> -->
                        <TableDocuments></TableDocuments>
                    </div>
                </div>
            </div>
        </div>
        <Modal
            :clasifications="clasifications"
            :dataFile="dataFile"
            :containers="containers"
            :typesDocument="typesDocument"
            :show="showModal"
            @showPreparation="showPreparation"
            @close="showModal = false"
            @resFile="resFile"
        ></Modal>
    </div>
    <div>
        <DocumentsPreparation
            v-show="showPrepa"
            :dataFile="dataFile"
            :resFiles="resFIles"
        ></DocumentsPreparation>
    </div>
</template>

<script setup>
import DocumentUpload from "../elements/DropZone.vue";
import $ from "jquery";
import { ref, reactive } from "vue";
import DocumentSearch from "./DocumentSearch.vue";
import DocumentsPreparation from "./DocumentsPreparation.vue";
import Home from "../Home.vue";
import TableDocuments from "../mydocuments/TableDocuments.vue";
import Modal from "../elements/Modal.vue";
import { useDropzone } from "vue3-dropzone";
import { useRouter } from "vue-router";
const router = useRouter();

const emit = defineEmits(["data"]);
const showModal = ref(false);
const clasifications = ref("");
const containers = ref("");
const typesDocument = ref("");
const showPrepa = ref("");
const resFiles = ref("")

const dataFile = ref("");
const shadow = ref(false);
const url = "{your_url}"; // Your url on the server side
const saveFiles = (files) => {
    const formData = new FormData();
    for (var x = 0; x < files.length; x++) {
        formData.append("images[]", files[x]);
    }
    // dataFile.value = formData
    // axios
    // .post(url, formData, {
    //     headers: {
    //     "Content-Type": "multipart/form-data",
    //     },
    // })
    // .then((response) => {
    //     console.info(response.data);
    // })
    // .catch((err) => {
    //     console.error(err);
    // });
};

function onDrop(acceptFiles, rejectReasons) {
    saveFiles(acceptFiles);
}

function clasificationData(clasification) {
    clasifications.value = clasification;
}

function containerData(container) {
    containers.value = container;
}

function typeDocumentData(typeDocument) {
    typesDocument.value = typeDocument;
}

function showPreparation(data) {
    showPrepa.value = data;
}

function resFile(resFile) {
    resFiles.value = resFile;
}

function onDropAccepted(acceptFiles) {
    saveFiles(acceptFiles);
    // dataFile.value = acceptFiles;
    var encoded = btoa(JSON.stringify(acceptFiles))
    var actual = JSON.parse(atob(encoded))
    console.log(actual);
    console.log(encoded);
    dataFile.value = encoded;


    showModal.value = true;

    // $('#standard-modal').modal('show');

    // router.push({ name: "DocumentsPreparation"
    //             , params: {datafile: JSON.stringify(dataFile)}})
}

const { getRootProps, getInputProps, ...rest } = useDropzone({
    onDrop,
    onDropAccepted,
});
</script>
