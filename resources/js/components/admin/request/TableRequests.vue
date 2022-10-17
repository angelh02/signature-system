<template>
    <div class="col">
        <div class="mx-2">
            <div class="col-5">
                <ul
                    class="nav nav-pills bg-nav-pills nav-justified mb-3"
                >
                    <li class="nav-item">
                        <a
                            href="#pendiente"
                            data-bs-toggle="tab"
                            aria-expanded="false"
                            class="nav-link rounded-0 active"
                            @click="tab = 'Pendiente'"
                        >
                            <i
                                class="mdi mdi-stop-circle-outline d-md-none d-block"
                            ></i>
                            <span class="d-none d-md-block"
                                >Pendiente</span
                            >
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            href="#aceptado"
                            data-bs-toggle="tab"
                            aria-expanded="true"
                            class="nav-link rounded-0"
                            @click="tab = 'Aceptado'"

                        >
                            <i
                                class="mdi mdi-book-check d-md-none d-block"
                            ></i>
                            <span class="d-none d-md-block"
                                >Aceptado</span
                            >
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            href="#rechazado"
                            data-bs-toggle="tab"
                            aria-expanded="true"
                            class="nav-link rounded-0"
                            @click="tab = 'Rechazado'"
                        >
                            <i
                                class="mdi mdi-clipboard-remove-outline d-md-none d-block"
                            ></i>
                            <span class="d-none d-md-block"
                                >Rechazado</span
                            >
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mx-2">
            <div class="table-responsive">
            <table class="table table-hover table-bordered" id="requests-table">
                <thead class="dripicons-checklist">
                    <tr>
                        <th>Folio</th>
                        <th>Asunto</th>
                        <th>Documento</th>
                        <th>Usuario</th>
                        <th>Estatus</th>
                        <th class="col-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="request in requests">
                        <td>{{request.id}}</td>
                        <td>{{request.subject}}</td>
                        <td>{{request.document.name}}</td>
                        <td>{{request.document.user.name}}</td>
                        <td>{{request.status}}</td>
                        <td class="d-flex">
                            <div v-if="tab === 'Pendiente'">
                                <button id="btn_editar" @click="aceptRequest(request)" class="mx-1 btn btn-success mdi mdi-check-outline"></button> 
                            </div>
                            <div v-if="tab === 'Pendiente'">
                                <button id="btn_borrar" @click="rejectRequests(request)" class="mx-1 btn btn-danger mdi mdi-cancel"></button>
                            </div>
                            <div :class="tab != 'Pendiente' && 'mx-4'">
                                <button id="btn_detalles" @click="modalRequests(request)" class="mx-1 btn btn-info mdi mdi-eye"></button>
                            </div>
                        </td>
                    </tr> 
                </tbody>
            </table>
        </div>
        </div>
        <ModalRequest :tab="tab" :formData="formData" @cancel="closeModal"/>
    </div>
</template>
    
<script setup>
import { ref, onMounted, watch, toRefs, reactive, nextTick } from "vue";
import $ from "jquery";
import { Modal, Popover } from "bootstrap";
import { useRouter, useRoute } from "vue-router";
import ModalRequest from "../request/ModalRequest.vue"
// import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, table, row, destroy, draw, buttons } from "datatables";
import { useRequests } from "@/js/composables/admin-apis/useRequest.js";
// clasificaciones
import useFileRquestAPI from "@/api/admin/deletion-request/index.js";
import {useToast} from "vue-toastification";

const toast = useToast();

const props = defineProps({
    filesClasification: Object,
    updated: Boolean,
});

const router = useRouter();
const route = useRoute();

// const { filesClasification } = toRefs(props)
const { updated } = toRefs(props);
const emit = defineEmits(["data"]);

const requests = ref("");
const allRequests = ref({});
const name = ref("");
const fila = ref("");
const visible = ref(false);
const refresh = ref(false);
const tab = ref("Pendiente")
const formData = reactive({
    id:"",
    subject:"",
    description:"",
    status:"",
    // document:"",
    document:{
        name:"",
        user:{
            name:"",
            surnames:"",
            user_name:"",
            email:""
        }
    }
});


//Modal const
const documentModal = ref({});

    
    
    
// const {getDocuments } = useDocumentsRequests();
const documents = ref("")
onMounted(async () => {
    getRequests();
});

function closeModal(){
    documentModal.value.hide();
}

const createTable = async () => {
    await nextTick(function() {
        $("#requests-table").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            },
            scrollCollapse: false,
        });
        
    }); 
}
    
function filterRequests(refresh = false){
    if (tab.value === "Rechazado"){
        requests.value = allRequests.value.filter(n=>n.status==="Rechazado")
        var dT = $('#requests-table').DataTable();
        dT.destroy();
        createTable()
        // if(!refresh)
        //     createTable();
        // else
        //     refreshTable();
    }
    else if (tab.value === "Aceptado"){
        requests.value = allRequests.value.filter(n=>n.status==="Aceptado")
        var dT = $('#requests-table').DataTable();
        dT.destroy();
        createTable()
        // if(!refresh)
        //     createTable();
        // else
        //     refreshTable();
    }
    else if(tab.value === "Pendiente"){
        requests.value = allRequests.value.filter(n=>n.status==="Pendiente")
        var dT = $('#requests-table').DataTable();
        dT.destroy();
        createTable()
        // if(!refresh)
        //     createTable();
        // else
        //     refreshTable();
    }
}

const getRequests = async (refresh = false) => {
    allRequests.value = await useFileRquestAPI.getAll([]);
    filterRequests(refresh);
    documentModal.value = new Modal($("#request-info-modal"));
};

const aceptRequest = async (request) => {
    const id = {
        id: request.id
    }
    useFileRquestAPI.acceptRequest(id)
    .then((res) => {
        toast.error("Se ha eliminado el folio "+ id + " correctamente", {
          timeout: 2000,
        });
        getRequests(true);
    });
   
};

const rejectRequests = async (request) => {
    const id = {
        id: request.id
    }
    useFileRquestAPI.rejectRequest(id)
    .then((res) => {
        toast.error("Se ha eliminado el folio "+ id + " correctamente", {
          timeout: 2000,
        });
        getRequests(true);
    });
   
};

const modalRequests = async (request) => {
    formData.id = request.id;
    formData.subject = request.subject;
    formData.description = request.description;
    formData.status = request.status;
    formData.document.name = request.document.name;
    formData.document.user.user_name = request.document.user.user_name;
    formData.document.user.email = request.document.user.email;
    formData.document.user.name = request.document.user.name;
    formData.document.user.surnames = request.document.user.surnames;
    documentModal.value.show();
   
};
    
watch(
    () => updated,
    (updated, oldUpdated) => {
        getRequests(true);
    },
    { deep: true },    
);

watch(
    () => tab,
    (tab, oldtab) => {
        filterRequests(true);
    },
    { deep: true },    
);
</script>
<style>
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
    -webkit-overflow-scrolling: touch;
        overflow: inherit;

}

</style>