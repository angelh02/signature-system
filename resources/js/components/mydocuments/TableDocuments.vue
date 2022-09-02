<template>
    <table v-if="documents.value"
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
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentTableRequest.js";
import useFileClasificationRequestsAPI from "@/api/index.js";

const { containerColumns, getDocuments } = useDocumentsRequests();
const documents = ref("")
onMounted(async () => {
    getRequests();
    // console.log(data)
});

const createTable = async () => {
    $("#example").dataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: documents.value,
        columns: containerColumns,
        scrollY: "45vh",
        scrollCollapse: false,
        destroy: true,
    });
}

const getRequests = async (refresh = false) => {
    const results = await getDocuments([]);
    documents.value = results;
    console.log(documents.value)
    createTable()
    // if(!refresh)
    //     createTable();
    // else
    //     refreshTable();
};
</script>
<style>
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
    -webkit-overflow-scrolling: touch;
        overflow: inherit;

}

</style>