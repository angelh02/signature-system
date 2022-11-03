<template>
    <table
        id="example"
        class="table table-sm table-striped"
        style="width: 100%"
    ></table>
    <ConfirmationModal
        :title="'Confirmación'"
        :message="func === '1' ? 'Éstas seguro que deseas eliminar a este usuario' : 'Éstas seguro que deseas restablecer contraseña del usuario'"
        @response="confirmationResponse"
    ></ConfirmationModal>
</template>

<script setup>
import { ref, onMounted, watch, toRefs, reactive } from "vue";
import $ from "jquery";
import { useRouter, useRoute } from "vue-router";
// import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, table, row, destroy, draw } from "datatables";
import { useAdminUser } from "@/js/composables/admin-apis/useAdminUser.js";
import useFileUserAPI from "@/api/admin/user/index.js";
import ConfirmationModal from "../../elements/ConfirmationModal.vue"
import { Modal } from "bootstrap";
import {useToast} from "vue-toastification";

const toast = useToast();
const confirmationModal= ref({});
const props = defineProps({
    filesClasification: Object,
    updated: Boolean,
});

const router = useRouter();
const route = useRoute();

// const { filesClasification } = toRefs(props)
const { updated } = toRefs(props);
const emit = defineEmits(["data"]);

const users = ref("");
const name = ref("");
const fila = ref("");
const userId = ref(0);
const visible = ref(false);
const refresh = ref(false);
const func = ref("")
const formData = reactive({
    id:"",
    name: "",
    surnames: "",
    user_name: "",
    email: "",
    active: 0,
    role_id:"",
    RFC:""
});



const userTable = ref("");

const { userColumns } = useAdminUser();


onMounted(async () => {
    getUser();
});

function confirmationResponse(response){
    confirmationModal.value.hide();
    if(response && func.value === "1")
        deleteUser(userId.value);
    else if (response && func.value === "2")
        restartPass(userId.value)
}

const refreshTable = async() => {
    userTable.value = $("#example").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: users.value,
        columns: userColumns,
        scrollY: "50vh",
        scrollCollapse: true,
        destroy: true,
    });
}

const createTable = async () => {
    userTable.value = $("#example").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
        },
        data: users.value,
        columns: userColumns,
        scrollY: "50vh",
        scrollCollapse: true,
        destroy: true,
    });
    userTable.value.on("click", "#btn_editar", function () {
        fila.value = $(this).closest("tr");
        let user = users.value;
        let usersId = parseInt(userTable.value.rows(fila.value).data()[0].id);
        let index = user.findIndex(x => x.id == usersId);
        formData.id = user[index].id;
        formData.name = user[index].name;
        formData.surnames = user[index].surnames;
        formData.user_name = user[index].user_name;
        formData.email = user[index].email;
        formData.active = user[index].active == 1 ? true : false;
        formData.role_id = user[index].roles[0].id;
        formData.RFC = user[index].RFC;
        emit("data", formData);
      
    });

    /* userTable.value.on("click", "#btn_borrar", function(){
        fila.value = $(this).closest("tr");           
        const id = parseInt(userTable.value.rows(fila.value).data()[0].id); 
        userId.value = id;
        func.value = "1"
        confirmationModal.value.show();
        // deleteUser(id);      
    });  */

    userTable.value.on("click", "#btn_reset", function(){
        fila.value = $(this).closest("tr");           
        const id = parseInt(userTable.value.rows(fila.value).data()[0].id); 
        userId.value = id;
        func.value = "2"
        confirmationModal.value.show();
        // restartPass(iduser);      
    }); 
};

const getUser = async (refresh = false) => {
    const info = await useFileUserAPI.getAll([]);
    users.value = info;
    confirmationModal.value = new Modal($("#confirmation-modal"))
    if(!refresh)
        createTable();
    else
        refreshTable();
};

const restartPass = async (id) => {
    const userid = {
        id: id
    }
    useFileUserAPI.resetPassword(userid)
    .then((res) => {
        toast.success("Se restablecio la contreaseña corecctamente", {
          timeout: 2000,
        });
        getUser(true);
    });
   
};

const deleteUser = async (id) => {
    useFileUserAPI.drop(id)
    .then((res) => {
        toast.success("Se ha eliminado el usuario correctamente", {
          timeout: 2000,
        });
        getUser(true);
    });
   
};


watch(
    () => updated,
    (updated, oldUpdated) => {
        getUser(true);
    },
    { deep: true },    
);


</script>