<template>
    <div>
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
                    <h3>Añadir participantes</h3>
                    <div class="py-2">
                        <ul class="nav nav-tabs mb-3">
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
                    <div class="tab-pane my-lg-n4" id="profile1">
                        <div
                            class="border text-white"
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

                    <div class="tab-pane active my-xxl-n4" id="home1">
                        <div class="card" style="background-color: #e9e9e9;">
                            <div class="card-body">
                                <form class="needs-validation"  novalidate>
                                    <div class="card" >
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
                                        class="btn btn-link"

                                        style="color: #3090b7;"
                                        type="button"
                                        @click="addRequest"
                                    >
                                    <h4 class="uil-plus-circle">Añadir firmante</h4>
                                        
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 row justify-content-center py-2">
                <div class="">
                    <div class="card rounded-4 border border-start">
                        <div class="card-header">
                            <h4 class="">Documento</h4>
                        </div>

                        <!-- <h6 class="card-header">Featured</h6> -->
                        <div class="card-body">
                            <div class="my-2">
                                <h4 class="">Clasificación</h4>
                            </div>
                            <div class="my-2">
                                <h4 class="">Fecha de expiración</h4>
                            </div>
                            <div class="my-2">
                                <h4 class="">Reccordatorios</h4>
                            </div>
                            <div class="row justify-items-center">
                                <button
                                    class="btn btn-primary mb-2"
                                    type="submit"
                                    @click.prevent=""
                                >
                                    SOLICITAR FIRMAS
                                </button>
                                <button
                                    class="btn btn-light mb-2"
                                    type="submit"
                                    @click=""
                                >
                                    CANCELAR
                                </button>
                            </div>
                        </div>
                        <!-- end card-body-->
                    </div>
                    <!-- end card-->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, toRef, reactive } from "vue";
import $ from 'jquery'
import { useRouter } from "vue-router";
import VuePdfEmbed from 'vue-pdf-embed'
import useDocumentRequestsAPI from "@/api/document/index.js";


const router = useRouter();
const formData = ref({
    name: "",
    email: "",
    document_id: 1
});


const source = "https://leo.uniandes.edu.co/images/Guias/Gua-para-resumen.pdf"

const props = defineProps({
    dataFile: Object,
});

const dataFile = toRef(props, "dataFile");
const data = ref("");

const addRequest = async => {
    console.log(formData.value)
    useDocumentRequestsAPI.addSigned(formData.value)
    .then((res) => {
    });
    // resetData();
}

function resetData(){
    formData.value.email = null;
    formData.value.name = "";
    formData.value.document_id = "";  
}



onMounted(async () => {   
    dataReceived();
    // console.log(data)fddd
});



function dataReceived() {
    // data.value = router.params.datafile
    console.log();
}

</script>
