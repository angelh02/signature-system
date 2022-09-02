<template>
    <div>
        <div v-if="!documentCreated">
            <div class="row">
                <div class="col-8">
                    <div class="row mx-2">
                        <div class="col-7">
                            <h1>Preparacion de documento</h1>
                        </div>
                        <div class="col-5 py-2">
                            <ul
                                class="nav nav-pills bg-nav-pills nav-justified mb-3"
                            >
                                <li class="nav-item">
                                    <a
                                        href="#home1"
                                        data-bs-toggle="tab"
                                        aria-expanded="false"
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
                                        aria-expanded="true"
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
                                        <VuePdfEmbed :source="source" :width="900"  class="scrollspy-example"></VuePdfEmbed>
                                    </div>
                                </div>
                                <!-- end card-body-->
                            </div>
                        </div>
                        <!-- Firmantes -->
                        <div class="tab-pane active my-xxl-n4" id="home1">
                            <h3>Añadir participantes</h3>
                            <div class="pt-2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a
                                            href="#firmantes"
                                            data-bs-toggle="tab"
                                            aria-expanded="false"
                                            class="nav-link rounded-bottom rounded-3 active"
                                            style="background-color: #a1a5ad"
                                        >
                                            <i
                                                class="mdi mdi-home-variant d-md-none d-block"
                                            ></i>
                                            <span class="d-none d-md-block text-white"
                                                >Firmantes</span
                                            >
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card" style="background-color: #e9e9e9;">
                                <div class="card-body">
                                    <form class="needs-validation"  novalidate>
                                        <div class="card mb-2" >
                                        <div class="row g-2 card-body" style="background-color: #f7f7f7;">
                                            <div class="mb-3 col-6">
                                                <label class="form-label"
                                                    >CORREO ELECTRÓNICO</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="email"
                                                    placeholder="correo@dominio.com"
                                                    v-model="formData.email"
                                                    required
                                                />
                                                <div class="invalid-feedback">
                                                    Please provide a valid zip.
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label"
                                                    >NOMBRE COMPLETO</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    placeholder="Nombre del Firmante"
                                                    v-model="formData.name"
                                                    required
                                                />
                                                <div class="invalid-feedback">
                                                    Please provide a valid zip.
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <button
                                            class="btn btn-sm btn-link p-1"
                                            type="button"
                                            @click="addRequest"
                                        >
                                        <h4 class="uil-plus-circle">Añadir firmante</h4>
                                            
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card" v-if="signers?.length > 0">
                                <div class="card-body pb-0">
                                    <h4 class="header-title mb-3">FIRMANTES</h4>

                                    <div class="inbox-widget mb-3">
                                        <div class="inbox-item" v-for="signer in signers">
                                            <p class="inbox-item-author">{{signer.name}}</p>
                                            <p class="inbox-item-text">{{signer.email}}</p>
                                            <p class="inbox-item-date">
                                                <button type="button" @click="deleteSigner(signer.id)" class="btn btn-sm btn-outline-danger px-1 py-0"> <i class="uil uil-trash-alt font-16"></i> </button>
                                            </p>
                                        </div>
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
                                        <a href="#" style="font-size: 0.8125rem">Descargar</a>
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
                                        class="btn btn-primary mb-2"
                                        type="button"
                                        @click="createDocument"
                                    >
                                        SOLICITAR FIRMAS
                                    </button>
                                    <a
                                        class="btn btn-light mb-2"
                                        type="button"
                                        href="/documents
                                        "
                                    >
                                        CANCELAR
                                    </a>
                                </div>
                            </div>
                            <!-- end card-body-->
                        </div>
                        <!-- end card-->
                    </div>
                </div>
            </div>
        </div>
        <DocumentCreated v-else></DocumentCreated>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, toRef, reactive } from "vue";
import $ from 'jquery'
import { useRouter } from "vue-router";
import VuePdfEmbed from 'vue-pdf-embed'
import useDocumentRequestsAPI from "@/api/document/index.js";
import DocumentCreated from "./DocumentCreated.vue";

const router = useRouter();
const formData = ref({
    name: "",
    email: "",
    document_id: 1
});
const signers = ref([]);
const documentData = ref({});
const documentCreated = ref(false);


const source = "https://leo.uniandes.edu.co/images/Guias/Gua-para-resumen.pdf"

const props = defineProps({
    dataFile: Object,
});

const dataFile = toRef(props, "dataFile");
const data = ref("");

const addRequest = async => {
    console.log(formData.value)
    useDocumentRequestsAPI.addSigner(formData.value)
    .then((res) => {
        signers.value = res;
        resetData();
    });
    // resetData();
}

const createDocument = asyc => {
    documentCreated.value = true;
}

const deleteSigner = async (id) => {
    useDocumentRequestsAPI.deleteSigner(id)
    .then((res) => {
        signers.value = res;
    });
}

function resetData(){
    formData.value.email = null;
    formData.value.name = "";
    formData.value.document_id = "";  
}



onMounted(async () => {   
    dataReceived();
    getDocumentData();
    // console.log(data)fddd
});

function dataReceived() {
    // data.value = router.params.datafile
    console.log();
}

function getDocumentData(){
    useDocumentRequestsAPI.getDocument(1)
    .then((res) => {
        documentData.value = res;
        signers.value = res?.document_signers;
    });
}

</script>
