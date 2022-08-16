<template>
    <div class="px-4">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h1 class="page-title">
                        Prepara un documento para ser firmado
                    </h1>
                </div>
            </div>
        </div>
        <DocumentUpload
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
                                >{{ dropzoneFile.name }}</a
                            >
                            <p class="mb-0" data-dz-size></p>
                        </div>
                        <div class="col-auto">
                            <!-- Button -->
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
        <div v-else></div>
        <div class="mt-3">
            <h5>Filtros rapidos
            </h5>
            <hr/>
        </div>
        <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card tilebox-one">
                <div class="card-body">
                    <DocumentSearch></DocumentSearch>
                </div> 
            </div>
        </div>

        <div class="col-xl-9 col-lg-8">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        Property HY1xx is not receiving hits. Either your site is not receiving any sessions or it is not tagged correctly.
                    </div>
                </div> 
            </div> 
        </div>
    </div>
    </div>
</template>

<script setup>
import DocumentUpload from "./DocumentUpload.vue";
import { ref } from "vue";
import DocumentSearch from "./DocumentSearch.vue";

let dropzoneFile = ref("");
const drop = (e) => {
    dropzoneFile.value = e.dataTransfer.files[0];
    console.log(dropzoneFile.value.name);
};
const selectedFile = () => {
    dropzoneFile.value = document.querySelector(".dropzoneFile").files[0];
};
// return { dropzoneFile, drop, selectedFile };
</script>
