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
import { useRouter, useRoute } from "vue-router";
// import ModalEdit from "../elements/ModalEdit.vue";
import { dataTable, table, row, destroy, draw } from "datatables";
import { useAdminUser } from "@/js/composables/admin-apis/useAdminUser.js";
import useFileUserAPI from "@/api/admin/user/index.js";

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

const users = ref("");
const name = ref("");
const fila = ref("");
const id = Object;
const visible = ref(false);
const refresh = ref(false);
const formData = reactive({
    id:"",
    name: "",
    surnames: "",
    user_name: "",
    email: "",
    active: 0,
    role_id:""
});



const userTable = ref("");

const { userColumns } = useAdminUser();


onMounted(async () => {
    getUser();
});

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
        console.log(usersId)
        emit("data", formData);
      
    });

    userTable.value.on("click", "#btn_borrar", function(){
        fila.value = $(this).closest("tr");           
        const id = parseInt(userTable.value.rows(fila.value).data()[0].id); 
        deleteUser(id);      
    }); 

    userTable.value.on("click", "#btn_reset", function(){
        fila.value = $(this).closest("tr");           
        const iduser = parseInt(userTable.value.rows(fila.value).data()[0].id); 
        restartPass(iduser);      
    }); 
};

const getUser = async (refresh = false) => {
    const info = await useFileUserAPI.getAll([]);
    users.value = info;
    if(!refresh)
        createTable();
    else
        refreshTable();
};

const restartPass = async (iduser) => {
    const userid = {
        id: iduser
    }
    console.log(userid)
    useFileUserAPI.resetPassword(userid)
    .then((res) => {
        toast.success("Se ha reseteado la contreaseña corecctamente", {
          timeout: 2000,
        });
        getUser(true);
    });
   
};

const deleteUser = async (id) => {
    useFileUserAPI.drop(id)
    .then((res) => {
        toast.success("Se ha eliminado el folio "+ id + " correctamente", {
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