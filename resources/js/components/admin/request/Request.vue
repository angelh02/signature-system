<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h1 class="page-title">Solicitudes</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-h-100">
                <div class="card-body">              
                    <TableRequests  @data="receivedData" :updated="updated"></TableRequests>
                </div> 
            </div> 
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted, watch, toRef, reactive } from "vue";
    import $ from 'jquery'
    import { useRouter, useRoute } from "vue-router";
    import TableRequests from "./TableRequests.vue";
    
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