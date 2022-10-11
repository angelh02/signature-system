<template>
    <div class="row">
        <div class="col-12">
            <div v-if="route.params.name === 'tipos-documentos'" class="page-title-box">
                <h1 class="page-title">Tipos de documentos</h1>
            </div>
            <div v-else class="page-title-box">
                <h1 class="page-title">Catálogo de clasificación archivística ({{route.params.name}})</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card tilebox-one">
                <div class="card-body">
                    <FormCatalogs :edit="edit" :route="route" :param="param" :dataForm="dataForm" @update="dataUpdated" @cancel="cancelUpdate"></FormCatalogs>
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
                    <TableCatalogs  @data="receivedData" :updated="updated"></TableCatalogs>
                </div> 
            </div> 
        </div>
    </div>
    
</template>
<script setup>
    import { ref, onMounted, watch, toRef, reactive } from "vue";
    import $ from 'jquery'
    import { useRouter, useRoute } from "vue-router";
    import FormCatalogs from "./FormCatalogs.vue";
    import TableCatalogs from "./TableCatalogs.vue";
    
    const router = useRouter();
    const route = useRoute();

    const edit = ref(false);
    const updated = ref(false);
    const param = ref("");

    const dataForm = ref({
        id:"",
        name: "",
        code: "",
    });

    function receivedData(data) {
        edit.value = true;
        dataForm.value = data
    }
    function dataUpdated() {
        updated.value = !updated.value;
    }

    function cancelUpdate(){
        dataForm.value = {
            name : "",
            code : ""
        };
        edit.value = false;
    }
</script>