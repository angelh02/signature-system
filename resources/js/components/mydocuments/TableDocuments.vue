<template>
    <table
        id="example"
        class="table table-striped cell-border"
        style="width: 100%"
    ></table>
</template>

<script setup>
import { ref, onMounted, watch, toRefs, reactive } from "vue";
import $ from "jquery";
import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, table, row, destroy, draw } from "datatables";
import { useDocumentsRequest } from "@/js/composables/useMyDocumentsRequest.js";
import useFileClasificationRequestsAPI from "@/api/index.js";

const { filesColumns, getClasification } = useDocumentsRequest();

const data = [
    {
    id: 2,
    name: "fer",
    participantes:"estos",
    create:"ala",
    firmado: "si",
    clasification: "5",
    start_end: "2022"
    },
    {
    id: 2,
    name: "fer",
    participantes:"estos",
    create:"ala",
    firmado: "si",
    clasification: "5",
    start_end: "2022"
    }
] 

onMounted(async () => {
    createTable();
    // console.log(data)
});

const createTable = async () => {
    $("#example").dataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: data,
        columns: filesColumns,
        scrollY: "50vh",
        scrollCollapse: true,
        destroy: true,
    });
}
</script>