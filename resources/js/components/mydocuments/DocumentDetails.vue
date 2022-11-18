<template>
    <div>
        <div v-if="!documentCreated">
            <div class="row">
                <div class="col-8">
                    <div class="row mx-0">
                        <div class="col-7">
                            <h1 class="text-black">Administrar documento</h1>
                        </div>
                        <div class="col-5 py-2">
                            <ul
                                class="nav nav-pills bg-nav-pills nav-justified mb-3"
                            >
                                <li class="nav-item">
                                    <a
                                        href="#home1"
                                        data-bs-toggle="tab"
                                        aria-expanded="true"
                                        class="nav-link rounded-0 active"
                                    >
                                        <i
                                            class="mdi mdi-home-variant d-md-none d-block"
                                        ></i>
                                        <span class="d-none d-md-block"
                                            >Preparación</span
                                        >
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="#profile1"
                                        data-bs-toggle="tab"
                                        aria-expanded="false"
                                        class="nav-link rounded-0"
                                    >
                                        <i
                                            class="mdi mdi-account-circle d-md-none d-block"
                                        ></i>
                                        <span class="d-none d-md-block"
                                            >Documento</span
                                        >
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content mx-2">
                        <div class="tab-pane my-lg-n4" id="profile1">
                            <div
                                class="border text-white mt-3"
                            >
                                <div
                                    class="card-body"
                                >
                                <div class="">
                                        <VuePdfEmbed v-if="source != ''" :source="source" :width="900"  class="scrollspy-example"></VuePdfEmbed>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Firmantes -->
                        <div class="tab-pane active my-xxl-n4" id="home1">
                            <div class="pt-2 mt-4">
                                <div class="col-7">
                                    <h2 class="text-black">Participantes</h2>
                                    <p class="h5 text-black-50">En esta sección, puedes revisar el estatus actual de cada participante. También puedes
                                       verificar los RFCs de las personas que ya firmaron</p>
                                </div>
                                <div class="card border border-2">
                                <div class="card-body">
                                    <form class="needs-validation"  novalidate>
                                        <div class="card m-0" >
                                        <div class="row" v-for="signer in signers">
                                            <template v-if="true">
                                                <div class="py-2 col-2 mx-3">
                                                    <span :class="'badge border border-light rounded rounded-4 p-2 bg-'+(signer.signed == 0  ? 'warning' : 'success') ">
                                                        <i :class="(signer.signed == 0 ? 'dripicons-clock' : 'dripicons-checkmark')"></i>
                                                        <span class="mx-1">{{signer.signed == 0 ? 'Pendiente' : 'Firmado'}}</span>
                                                    </span>
                                                </div>
                                                <div class="col-7 py-2 mx-xxl-n4">
                                                    <h5 class="text-black m-0">{{signer.user.email}} - {{signer.user.name}} {{signer.user.surnames}} {{signer.user_id == userLogged.id? '(Tú)' : ''}}</h5> 
                                                    <p class="inbox-item-text m-0">RFC: {{signer.user.RFC}}</p>                                     
                                                </div>
                                                <div class="col text-end py-2 mx-3">
                                                    <button
                                                        class="btn btn-info mx-1 mb-2"
                                                        :disabled="signer.signed == 1"
                                                        @click="remindSigner(signer?.user_id)"
                                                    >
                                                        <span class="uil uil-bell font-16"></span>
                                                    </button>
                                                    <a
                                                        v-if="false"
                                                        class="btn btn-danger mx-1 mb-2"
                                                        type="button"
                                                        @click="deleteSigner(signer.id)"
                                                    >
                                                        <span class="uil uil-trash-alt font-16"></span>
                                                        
                                                    </a>
                                                </div>
                                            </template>
                                        </div>
                                        
                                    </div>
                                    
                                    </form>
                                </div>
                            </div>
                            <div>
                                <button
                                    v-if="false"
                                    class="btn btn-outline-danger col-3 py-xxl-0"
                                    type="button"
                                    :disabled="documentData.signed === 1"
                                    @click="openModal"
                                >
                                    <h4 class="uil-plus-circle">Añadir firmante</h4>
                                        
                                </button>
                                <div v-if="documentData.signed === 1"  class="my-2 alert alert-warning alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Aviso - </strong> Este documento ya ha sido firmado.
                                </div>
                            </div>
                               
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4 row justify-content-center py-2">
                    <div class="">
                        <div class="card rounded-4 border border-start">
                            <div class="card-body">
                                <p><b>Documento</b></p>
                                <div class="inbox-widget mb-2">
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
                                <div class="row justify-items-center ps-2 pe-2">
                                    <button
                                        class="btn btn-outline-danger mb-2"
                                        type="button"
                                        v-if="documentData?.id != null && documentData.signed != 1"
                                        @click="deleteDocument"
                                    >
                                        <h5>ELIMINAR DOCUMENTO</h5>
                                    </button>
                                    <button
                                        class="btn btn-outline-danger mb-2"
                                        type="button"
                                        v-if="documentData?.id != null && documentData.signed == 1 && documentData.deletion_requests.length == 0"
                                        @click="openDeletionRequest"
                                    >
                                        <h5>ELIMINAR DOCUMENTO</h5>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <DocumentCreated v-else></DocumentCreated>
        <!-- Deletion request modal -->
        <CreateDeletionRequestModal
            :document-id="documentData?.id"
            @cancel="cancelDeletionRequest"
            @stored="storedDeletionRequest"
        >
        </CreateDeletionRequestModal>
        <!-- Deletion confirmation modal -->
        <ConfirmationModal
            :title="'Confirmacion de Eliminación'"
            :message="'Estas seguro de eliminar el siguiente documento'"
            @response="confirmationResponse"
        ></ConfirmationModal>
        <ModalSigner :signers="signers" :userLogged="userLogged" :formData="formData" @cancel="closeModal" @add="addSigners"></ModalSigner>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, toRef, reactive, useAttrs } from "vue";
import $ from 'jquery';
import { Modal, Popover } from "bootstrap";
import { useRouter, useRoute } from "vue-router";
import VuePdfEmbed from 'vue-pdf-embed'
import useDocumentRequestsAPI from "@/api/document/index.js";
import DocumentCreated from "./DocumentCreated.vue";
import ConfirmationModal from "../elements/ConfirmationModal.vue";
import ModalSigner from "./ModalSigner.vue";
import CreateDeletionRequestModal from "./CreateDeletionRequestModal.vue";
import {useToast} from "vue-toastification";
import useSignRequestsAPI from "@/api/sign-document/index.js";

const attrs = useAttrs();
const userLogged = ref(attrs.user);

const confirmationModal= ref({});
const deletionRequestModal = ref({});

const toast = useToast();
const router = useRouter();
const route = useRoute();
const formData = ref({
    id: "",
    email: "",
});
const signers = ref([]);
const documentId = ref(0);
const documentData = ref({});
const documentCreated = ref(false);
const documentDownload = ref("");
const documentModal = ref({});
const signer = ref({
    user_id:"",
    document_id:""
})
const source = ref("");

const props = defineProps({
    dataFile: Object,
    resFiles: Object
});

const dataFile = toRef(props, "dataFile");
const resFiles = toRef(props, "resFiles");

const data = ref("");

//Functions
function cancelDeletionRequest(){
    deletionRequestModal.value.hide();
}

function storedDeletionRequest(){
    deletionRequestModal.value.hide();
    getDocumentData();
}

function openDeletionRequest(){
    deletionRequestModal.value.show();
}

function closeModal(){
    resetData();
    documentModal.value.hide();
}

function openModal(){
    documentModal.value.show();
}

const addSigners = async(add) => {
    // formData.value = add
    signer.value.user_id = formData.value.id
    signer.value.document_id = formData.value.document_id
    console.log(signer.value)
    useDocumentRequestsAPI.addSigner(signer.value)
    .then((res) => {
        resetData();
        signers.value = res;
            toast.success("Se ha agregado corectamente", {
            timeout: 2000,
            });
            closeModal();
        })  
        .catch(error => 
            toast.warning("No se ha podido Agregar", {
            timeout: 2000,
            })
        );
    // resetData();
}

const createDocument = asyc => {
    documentCreated.value = true;
}

function confirmationResponse(response){
    confirmationModal.value.hide();
    if(response)
        deleteDocumentRequest();
}

const deleteSigner = async (id) => {
    useDocumentRequestsAPI.deleteSigner(id)
    .then((res) => {
        signers.value = res;
        toast.success("Se ha eliminado corectamente", {
          timeout: 2000,
        });
    });
}

function deleteDocument(){
    confirmationModal.value.show();
}

function resetData(){
    formData.value.email = null;
    formData.value.id = "";
    // formData.value.document_id = parseInt(route.params.id);  
}



onMounted(async () => {   
    documentId.value = parseInt(route.params.id);
    formData.value.document_id = documentId.value;
    documentModal.value = new Modal($("#request-info-modal"));
    confirmationModal.value = new Modal($("#confirmation-modal"));
    deletionRequestModal.value = new Modal($("#deletion-request-modal"));
    getDocumentData();
});

function deleteDocumentRequest(){
    if(documentData.value.signed === 1){
        useDocumentRequestsAPI.deleteDocument(documentId.value)
        .then((res) => {
            router.push({path:'/mis-documentos'});
        });
    }
}

async function getDocumentData(){
    await useDocumentRequestsAPI.getDocument(documentId.value)
    .then((res) => {
        documentData.value = res;
        signers.value = res?.document_signers;
        if(userLogged.value.id != documentData.value.user_id)
            router.push({path:'/mis-documentos/estado/'+documentData.value.id});
        console.log(documentData.value)
    });
    
    //source.value = "https://cdn.filestackcontent.com/wcrjf9qPTCKXV3hMXDwK";
    source.value = await useSignRequestsAPI.getDocumentBase(documentData.value.aws_document_id, userLogged.value.aws_auth_token);
}

function remindSigner(signerId){
    console.log("🚀 ~ file: DocumentDetails.vue ~ line 356 ~ remindSigner ~ signerId", signerId)
    console.log("🚀 ~ file: DocumentDetails.vue ~ line 356 ~ remindSigner ~ signerId", {
        document_id : documentData.value.id,
        user_id : signerId
    });
    
    useDocumentRequestsAPI.remindSigner({
        document_id : documentData.value.id,
        user_id : signerId
    })
    .then((res) => {
        toast.success("Se ha notificado correctamente", {
          timeout: 2000,
        });
    });
}

</script>
