<template>
    <div class="modal fade" id="request-info-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Añadir firmante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" @submit.prevent="onSubmit" novalidate>
                        <!-- <div class="mb-3">
                            <label class="form-label"
                                >Nombre de usuario</label
                            >
                            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="user_name"
                                    placeholder="Ingrese"
                                    minlength="1"
                                    maxlength="10"
                                    v-model="v$.name.$model"
                                    required
                                />
                                <div v-for="(error, index) in v$.name.$errors" :key="index" class="invalid-feedback d-block">
                                    {{ error.$message }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"
                                >Email</label
                            >
                            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    placeholder="Ingrese"
                                    minlength="5"
                                    maxlength="255"
                                    v-model="v$.email.$model"
                                    required
                                />
                                <div v-for="(error, index) in v$.email.$errors" :key="index" class="invalid-feedback d-block">
                                    {{ error.$message }}
                                </div>
                            </div>
                        </div> -->
                        <div class="mb-3">
                        <label class="form-label"
                            >NOMBRE COMPLETO
                            {{users.length}}    
                        </label
                        >
                        <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                            <select
                                class="form-select select2"
                                data-toggle="select2"
                                id="users"
                                name="users"
                                v-model.trim="v$.id.$model"
                            >
                                <option selected disabled value=""
                                    >--Selecciona la opción deseada--</option
                                >
                                <template v-for="user in users" :key="user.id">
                                    <option 
                                        :value="user.id"
                                        :disabled="!userEnable(user.id)"
                                    >
                                        {{ user.user_name+' - '+user.name+' '+user.surnames }}
                                    </option>

                                </template>
                                
                            </select>
                            <div v-for="(error, index) in v$.id.$errors" :key="index" class="invalid-feedback d-block">
                                {{ error.$message }}
                            </div>
                        </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label"
                                >CORREO ELECTRÓNICO</label
                            >
                            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    placeholder="correo@dominio.com"
                                    v-model="v$.email.$model"
                                    required
                                    :disabled="true"
                                />
                                <div v-for="(error, index) in v$.email.$errors" :key="index" class="invalid-feedback d-block">
                                    {{ error.$message }}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <div v-for="user in users" :key="user.id">
                        <button type="button" class="btn btn-success" @click="addSigner()" :disabled="!userEnable(user.id)">Añadir</button>
                    </div> -->
                    <button type="button" class="btn btn-success" 
                            @click="addSigner()" 
                            :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0"
                    >
                            Añadir
                    </button>

                    
                    <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </template>
    <script setup>
    import { ref, toRef, onMounted, reactive, useAttrs, watch} from 'vue';
    import $ from "jquery";
    import select2 from "select2";
    import { useVuelidate } from '@vuelidate/core';
    import { required, email ,minValue, helpers, minLength, maxLength} from '@vuelidate/validators';
    import useDocumentRequestsAPI from "@/api/document/index.js";
    import useUserRequestsApi from "@/api/admin/user/index.js"
    import {useToast} from "vue-toastification";

    // const attrs = useAttrs();
    // const userLogged = ref(attrs.user);
    
    const emit = defineEmits(["cancel","add"]);
    const toast = useToast();
    const props = defineProps({
        formData: Object,
        tab: String,
        userLogged: Object,
        signers: Array
    });

    //select 2 info
    const users = ref([]);
    const userSelected = ref({});
    
    //ReadOnly
    const formData = toRef(props, 'formData');
    const userLogged = toRef(props, 'userLogged');
    const dataForm = reactive(formData);
    const signers = toRef(props, 'signers');

    
    const rules = {
        id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
        email : {
            required: helpers.withMessage('Este campo no debe estar vacio', required)
        },
     };

    const v$ = useVuelidate(rules, dataForm);
    
    onMounted(async => {
        $(function(){
            function userSelect(user){
                if(user.id != ""){
                    userSelected.value = users.value.filter(x => x.id == user.id)[0];
                    v$._value.id.$model = userSelected.value.id
                    v$._value.email.$model = userSelected.value.email;
                }
                return user.text;
            }
            $('#users').select2({
                templateSelection: userSelect,
                dropdownParent: $('#request-info-modal')
            });
        });
        getRequest();
    })

    watch(
        () => signers,
        (signers, oldSigners) => {
            refreshSelect();
        },
        {deep:true}
    );

    const getRequest = async () => {
        //get all users
        let usersList = await useUserRequestsApi.getAll();
        console.log(userLogged.value)
        users.value = usersList.filter(x => x.roles[0].name != "Administrador" && userLogged.value.id != x.id);
        console.log("user",users.value)
        refreshSelect();
    }

    function refreshSelect(){
        $(function(){
            function userSelect(user){
                if(user.id != ""){
                    userSelected.value = users.value.filter(x => x.id == user.id)[0];
                    v$._value.id.$model = userSelected.value.id
                    v$._value.email.$model = userSelected.value.email;
                }
                return user.text;
            }
            $('#users').select2({
                templateSelection: userSelect,
                dropdownParent: $('#request-info-modal')
            });
        });
    }

    // const addSigners = async => {
    //     useDocumentRequestsAPI.addSigner(dataForm.value)
    //     .then((res) => {
    //         // signers.value = res;
    //         closeModal();
    //         toast.success("Se ha agragado corectamente", {
    //         timeout: 2000,
    //         });
    //     })  
    //     .catch(error => 
    //         toast.warning("No se ha podido Agregar", {
    //         timeout: 2000,
    //         })
    //     );
    // }

    function resetData(){
        dataForm.value.email = null;
        dataForm.value.id = "";
    }

    function addSigner(){
        emit('add')
        v$._value.$reset();
    }

    function closeModal(){
        resetData();
        v$._value.$reset();
        refreshSelect();
        emit('cancel');
    }

    function userEnable(userId){
        if(signers.value.length == 0 || (signers.value.length > 0 && signers.value.findIndex(x => x.user_id == userId) == -1))
            return true;
        return false;
    }
    </script>