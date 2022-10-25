<template>
    <div class="container p-3 pt-2">
        <div class="row" v-if="!submited">
            <div class="col-4">
                <div class="card border border-1 shadow p-3 mb-3 bg-body rounded pt-0 ps-0 pe-0">
                    <div class="card-header p-0">
                        <ul class="nav nav-pills bg-nav-pills nav-justified">
                            <li class="nav-item">
                                <a @click="changeTab(1)" type="button" id="tab-pdf" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Revisa</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a @click="changeTab(2)" type="button" id="tab-sign" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Firma</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pb-2">
                        <div class="tab-content">
                            <div class="tab-pane" id="card-pdf">
                                <p>
                                    Revisa el documento y cuando estes listo, da
                                    clic en el botón “Continuar a firmar”. Si hay una
                                    que te impida hacerlo, da clic en enlace “Hay un
                                    problema con el documento”
                                </p>
                                <div class="text-center">
                                    <a class="btn btn-primary" style="width: 80%;" @click="changeTab(2)">CONTINUAR A FIRMAR</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="card-sign">
                                <p>
                                    Para firmar, necesitarás los archivos de tu e.firma (anteriormente FIEL).
                                </p>
                                <p>
                                    Los datos sensibles de tu e.firma
                                    <b>nunca se comparten con esta plataforma.</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Info documento -->
                <div class="card border border-1 shadow p-3 mb-3 bg-body rounded pt-0 ps-0 pe-0">
                    <div class="card-body">
                        <p><b>Documento</b></p>
                        <div class="inbox-widget">
                            <div class="inbox-item">
                                <div class="inbox-item-img"><i class="mdi mdi-48px mdi-file-document-outline"></i></div>
                                <p class="inbox-item-author">{{documentData?.name}}</p>
                                <p class="inbox-item-text">Creado el {{documentData?.created_at}}</p>
                                <a v-if="documentDownload != ''" :href="documentDownload" style="font-size: 0.8125rem">Descargar</a>
                            </div>
                            <div class="inbox-item">
                                <p class="inbox-item-author">Tipo de documento</p>
                                <p class="inbox-item-text">{{documentData?.document_type?.code+' - '+documentData?.document_type?.name}}</p>
                            </div>
                            <div class="inbox-item">
                                <p class="inbox-item-author">Clasificación del documento</p>
                                <p class="inbox-item-text">{{documentData?.classification?.name}}</p>
                            </div>
                            <div class="inbox-item">
                                <p class="inbox-item-author">Contenedor del documento</p>
                                <p class="inbox-item-text">{{documentData?.container?.name}}</p>
                            </div>
                        </div>
                        <p class="pt-2 pb-1 m-0"><b>Estado del documento</b></p>
                        <p class="pb-1 m-0" style="font-size: 0.8125rem">
                            Para revisar las firmas solicitadas para este
                            documento y el estado actual de cada una, haz
                            clic en el siguiente enlace.
                        </p>
                        <router-link :to="`/document/status/${documentData?.id}`" style="font-size: 0.8125rem">Estado actual del documento</router-link>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="tab-content">
                    <div class="tab-pane" id="pdf-viewer">
                        <div class="tab-pane" id="profile1">
                            <div class="d-flex align-items-center" v-if="isLoading">
                                <strong>Loading...</strong>
                                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                            </div>
                            <div
                                class="card bg-secondary text-white rounded"
                                style="background-color: #a1a5ad"
                                v-else
                            >
                                <!-- <div class="card-header">
                                    <span>
                                    <button :disabled="page <= 1" @click="page--">❮</button>
                            
                                    {{ page }} / {{ pageCount }}
                            
                                    <button :disabled="page >= pageCount" @click="page++">❯</button>
                                    </span>
                                </div> -->
                                <div
                                    class="card-body"
                                    style="background-color: #a1a5ad"
                                >
                                    <VuePdfEmbed
                                        v-if="source != ''"
                                        class="scrollspy-example"
                                        ref="pdfRef" 
                                        :source="source"
                                        :page="1"
                                        @password-requested="handlePasswordRequest"
                                        @rendered="handleDocumentRender"
                                    ></VuePdfEmbed>
                                </div>
                                <!-- end card-body-->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="sign-form">
                        <div class="accordion custom-accordion" id="custom-accordion-one">
                            <div class="card mb-0">
                                <div class="card-header" id="cer-file">
                                    <h5 class="m-0">
                                        <a id="up-cer-btn" class="custom-accordion-title d-block py-1"
                                            data-bs-toggle="collapse" href="#up-cer"
                                            aria-expanded="true" aria-controls="up-cer">
                                            1. Selecciona el certificado (archivo .cer) <i
                                                class="mdi mdi-chevron-down accordion-arrow"></i>
                                        </a>
                                    </h5>
                                </div>
                                    
                                <div id="up-cer" class="collapse show"
                                    aria-labelledby="cer-file"
                                    data-bs-parent="#up-cer">
                                    <div class="card-body">
                                        <div>
                                            <div class="dropzone" v-bind="getRootProps()">
                                                <div class="dz-message needsclick row align-items-center">
                                                    <input v-bind="getInputProps()" />
                                                        <h4 class="text-muted mdi mdi-file-upload-outline">
                                                            Arrastra tu archivo .cer aqui o
                                                            <label
                                                                ><a type="button" class="text-primary"
                                                                    >click aquí para seleccionar uno</a
                                                                ></label
                                                            >
                                                            <input
                                                                class="dropzoneFile btn-check"
                                                            />
                                                        </h4>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-0">
                                <div class="card-header" id="key-file">
                                    <h5 class="m-0">
                                        <a id="up-key-btn" class="custom-accordion-title collapsed d-block py-1"
                                            data-bs-toggle="collapse" href="#up-key"
                                            aria-expanded="false" aria-controls="up-key">
                                            2. Selecciona la llave privada (archivo .key) <i
                                                class="mdi mdi-chevron-down accordion-arrow"></i>
                                        </a>
                                    </h5>
                                </div>
                                <div id="up-key" class="collapse"
                                    aria-labelledby="key-file"
                                    data-bs-parent="#custom-accordion-one">
                                    <div class="card-body">
                                        <div>
                                            <div class="dropzone" v-bind="getRootProps()">
                                                <div class="dz-message needsclick row align-items-center">
                                                    <input v-bind="getInputProps()" />
                                                        <h4 class="text-muted mdi mdi-file-upload-outline">
                                                            Arrastra tu archivo .key aqui o
                                                            <label
                                                                ><a type="button" class="text-primary"
                                                                    >click aquí para seleccionar uno</a
                                                                ></label
                                                            >
                                                            <input
                                                                class="dropzoneFile btn-check"
                                                            />
                                                        </h4>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-0">
                                <div class="card-header" id="password-form">
                                    <h5 class="m-0">
                                        <a id="password-btn" class="custom-accordion-title collapsed d-block py-1"
                                            data-bs-toggle="collapse" href="#password-tab"
                                            aria-expanded="false" aria-controls="password-tab">
                                            3. Ingresa la contraseña de tu e.firma <i
                                                class="mdi mdi-chevron-down accordion-arrow"></i>
                                        </a>
                                    </h5>
                                </div>
                                <div id="password-tab" class="collapse" aria-labelledby="password-form"
                                    data-bs-parent="#custom-accordion-one">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label">Ingresa tu contraseña:</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control " name="password" required="" autocomplete="current-password" placeholder="Introduce tu contraseña">
                                                <button id="password-type" class="input-group-text" @click="changeInputText">
                                                    <span class="password-eye"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" @click="signDocument" :disabled="submit || step != 2" >
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="submit"></span>
                                FIRMAR DOCUMENTO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <DocumentSigned v-if="submited"></DocumentSigned>
    </div>
</template>
<script setup>
import DocumentUpload from "../elements/DropZone.vue";
import $ from 'jquery'
import { ref, onMounted, toRefs, toRef, reactive } from "vue";
import { useDropzone } from "vue3-dropzone";
import VuePdfEmbed from 'vue-pdf-embed'
import DocumentSigned from "./DocumentSigned.vue"
import {useRoute} from 'vue-router';
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentsRequest.js";
import useDocumentsRequestsAPI from "@/api/document/index.js";

const route = useRoute();
//Extract functions about requests
const { getDocument } =
    useDocumentsRequests();
//Cargar pdf
const source = ref("");
const page = ref(null);
const pageCount = ref(1);
const isLoading = ref(false);
const step = ref(0);

const documentsFiles = ref([
    {
        name:"minuta_reunion.pdf",
        url:"https://drive.google.com/uc?id=1e4Pg3SkXZh6NEldfTNTUmzTGxE3VQlvd&export=download",
        pdf_url:"https://drive.google.com/uc?id=15zd4xb1dOUigrrcNc9ap6LPakfQrj6rf&export=download",
        xml_url:"https://drive.google.com/uc?id=15zd4xb1dOUigrrcNc9ap6LPakfQrj6rf&export=download"
    },
    {
        name:"lista_asistencia.pdf",
        url:"https://drive.google.com/uc?id=1sJ1hGDWhFW-3etoSo5gnUAatUxiImXrj&export=download",
        pdf_url:"https://drive.google.com/uc?id=1Uw0xeRpr9G8ZPLYBvd9edUV6wS01FA8a&export=download",
        xml_url:"https://drive.google.com/uc?id=1Uw0xeRpr9G8ZPLYBvd9edUV6wS01FA8a&export=download"
    },
    {
        name:"constancia_servicio_social.pdf",
        url:"https://drive.google.com/uc?id=1QvAC2oJqRnUHddwkJiUOkxIQJ5jyb5ln&export=download",
        pdf_url:"https://drive.google.com/uc?id=1any8k0DPl9_7nbeeNbJdTo3XhMzXDiFG&export=download",
        xml_url:"https://drive.google.com/uc?id=1any8k0DPl9_7nbeeNbJdTo3XhMzXDiFG&export=download"
    },
    {
        name:"carta_no_adeudo.pdf",
        url:"https://drive.google.com/uc?id=1IO2e-rsr0WKXRSF9VrwTBz92VSqthpyK&export=download",
        pdf_url:"https://drive.google.com/uc?id=1Ofd4anX48iI1VsCO39NjKMutSpoqtHr0&export=download",
        xml_url:"https://drive.google.com/uc?id=1Ofd4anX48iI1VsCO39NjKMutSpoqtHr0&export=download"
    },
    {
        name:"acta_calificaciones.pdf",
        url:"https://drive.google.com/uc?id=1tEg_1Kt6N97-waTcHtmIVsR2Tm_ztOl7&export=download",
        pdf_url:"https://drive.google.com/uc?id=1ehzwQHmBGlpHA8DSMAG9lWV9z3ZdI8Gs&export=download",
        xml_url:"https://drive.google.com/uc?id=1ehzwQHmBGlpHA8DSMAG9lWV9z3ZdI8Gs&export=download"
    },
])

//Dropzone
const dataFile = ref("");
const { getRootProps, getInputProps, ...restCer } = useDropzone({ onDrop, onDropAccepted });

//Subir info
const submit = ref(false);
const submited = ref(false);
const documentId = ref(0);
const documentData = ref({});
const documentDownload = ref("");
const signData = ref({
    id : 0,
    pdf_url : "",
    xml_url : ""
});

onMounted(async () => {
    documentId.value = parseInt(route.params.id);
    searchDocument();
   $("#tab-pdf").addClass("active");
   $("#pdf-viewer").addClass("show active");
   $("#card-pdf").addClass("show active");
});

function changeInputText(){
    if($('#password').attr('type') == 'password')
        $('#password-type').addClass("show-password");
    else
        $('#password-type').removeClass("show-password");
    $('#password').attr('type', $('#password').attr('type') == 'text' ? 'password' : 'text');
    
}

function changeTab(tab){
    if(tab == 1){
        $("#tab-sign").removeClass("active");
        $("#sign-form").removeClass("show active");
        $("#card-sign").removeClass("show active");
        $("#tab-pdf").addClass("active");
        $("#pdf-viewer").addClass("show active");
        $("#card-pdf").addClass("show active");
    }
    else{
        $("#tab-pdf").removeClass("active");
        $("#pdf-viewer").removeClass("show active");
        $("#card-pdf").removeClass("show active");
        $("#tab-sign").addClass("active");
        $("#sign-form").addClass("show active");
        $("#card-sign").addClass("show active");
    }
}

//Events to pdf viewer
function handleDocumentRender() {
    isLoading.value = false
};
function handlePasswordRequest(callback, retry) {
    callback(prompt(retry
    ? 'Enter password again'
    : 'Enter password'
    ))
};

//Functions to dropzone
function onDrop(acceptFiles, rejectReasons) {
    saveFilesCer(acceptFiles);       
}

function onDropAccepted(acceptFiles) {
    saveFilesCer(acceptFiles); 
    dataFile.value = acceptFiles
    step.value ++;
    if(step.value == 1){
        $("#up-cer-btn").attr('aria-expanded', "false");
        $("#up-cer-btn").addClass("collapsed");
        $("#up-cer").removeClass("show");
        $("#up-key-btn").attr('aria-expanded', "true");
        $("#up-key-btn").removeClass("collapsed");
        $("#up-key").addClass("show");
        $("#password-btn").attr('aria-expanded', "false");
        $("#password-btn").addClass("collapsed");
        $("#password-tab").removeClass("show");
    }
    else if(step.value == 2){
        $("#up-key-btn").attr('aria-expanded', "false");
        $("#up-key-btn").addClass("collapsed");
        $("#up-key").removeClass("show");
        $("#password-btn").attr('aria-expanded', "true");
        $("#password-btn").removeClass("collapsed");
        $("#password-tab").addClass("show");
        $("#up-cer-btn").attr('aria-expanded', "false");
        $("#up-cer-btn").addClass("collapsed");
        $("#up-cer").removeClass("show");
    }
    // router.push({ name: "DocumentsPreparation"
    //             , params: {datafile: JSON.stringify(dataFile)}})
    
}

const saveFilesCer = (files) => {
    const formData = new FormData();
    for (var x = 0; x < files.length; x++) {
        formData.append("images[]", files[x]);
    }
};

const saveFilesKey = (files) => {
    const formData = new FormData();
    for (var x = 0; x < files.length; x++) {
        formData.append("images[]", files[x]);
    }
};
const searchDocument = async () => {
    documentData.value = await getDocument(documentId.value);
    let index = documentsFiles.value.findIndex(x => x.name == documentData.value.name);
    index = index == -1 ? 0 : index;
    source.value = "/pdf/"+(documentsFiles.value[index].name);
    documentDownload.value = documentsFiles.value[index].url;
    signData.value.id = documentData.value.id;
    signData.value.pdf_url = documentsFiles.value[index].pdf_url;
    signData.value.xml_url = documentsFiles.value[index].xml_url;
};
const signDocument = async () => {
    submit.value = true;
    useDocumentsRequestsAPI.signDocument(signData.value)
    .then((res) => {
        setTimeout(function() {
            submit.value = false;
            submited.value = true;
            step.value = 0;
        }, 3000);
    });
};
</script>