<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h1 class="page-title">Catálogo de contenedores archivisticos</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card tilebox-one">
                <div class="card-body">
                    <NewContainer :edit="edit" :dataForm="dataForm" @update="dataUpdated" @cancel="cancelUpdate"></NewContainer>
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
                    <TableContainers  @data="receivedData" :updated="updated"></TableContainers>
                </div> 
            </div> 
        </div>
    </div>
</template>

<script setup>
import NewContainer from './NewContainer.vue';
import TableContainers from './TableContainers.vue';
import {ref,onMounted,watch,reactive} from 'vue';
// import $ from 'jquery';


const updated = ref(false);
const edit = ref(false);
const dataForm = ref({
    id:"",
    conservation_time_id: "",
    conservation_type_id: "",
    document_value_id: "",
    information_type_id: "",
    selection_technique_id: "",
    effective_date: "",
});
// const id = ref("");


function cancelUpdate(){
    edit.value = false;
}

function dataUpdated() {
    updated.value = !updated.value;
}

function receivedData(data) {
    edit.value = true;
    dataForm.value = data
}

// function receivedId(data) {
//     id.value = data
// }
</script>
