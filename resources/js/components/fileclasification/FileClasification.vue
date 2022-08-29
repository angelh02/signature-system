<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h1 class="page-title">Catálogo de clasificación archivística</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card tilebox-one">
                <div class="card-body">
                    <Newclasification  :dataForm="dataForm" @update="dataUpdated"></Newclasification>
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
                    <TableClasification @id="receivedId" @data="receivedData" :updated="updated"></TableClasification>
                </div> 
            </div> 
        </div>
    </div>
</template>

<script setup>
import Newclasification from './Newclasification.vue';
import TableClasification from './TableClasification.vue';
import {ref,onMounted,watch} from 'vue';
// import $ from 'jquery';


const updated = ref(false);
const dataForm = ref("");
const id = ref("");


function dataUpdated() {
    updated.value = !updated.value;
}

function receivedData(data) {
    dataForm.value = data
}

// function receivedId(data) {
//     id.value = data
// }
</script>
