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
                        <div class="mb-3">
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
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="addSigner()">Añadir</button>
                    <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </template>
    <script setup>
    import { ref, toRef, onMounted, reactive} from 'vue';
    import $ from "jquery";
    import { useVuelidate } from '@vuelidate/core';
    import { required, email ,minValue, helpers, minLength, maxLength} from '@vuelidate/validators';
    import useDocumentRequestsAPI from "@/api/document/index.js";
    import {useToast} from "vue-toastification";


    
    const emit = defineEmits(["cancel","add"]);
    const toast = useToast();
    const props = defineProps({
        formData: Object,
        tab: String
    });
    
    //ReadOnly
    const formData = toRef(props, 'formData');

    const dataForm = reactive(formData);

    
    const rules = {
       
        name: {
         required: helpers.withMessage('Este campo no debe estar vacio', required),
         minLength: helpers.withMessage('Minimo debe ser 10 caracteres', minLength(10)),
         maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
       }, 
       
        email: {
         required: helpers.withMessage('Este campo no debe estar vacio', required),
         minLength: helpers.withMessage('Minimo debe ser 5 caracteres', minLength(5)),
         maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
         email: helpers.withMessage('Debe ser un email valido', email)
       },
       document_id:{
        required: helpers.withMessage('Este campo no debe estar vacio', required)
      }
     };

    const v$ = useVuelidate(rules, dataForm);
    
    const addSigners = async => {
        console.log(dataForm.value)
        useDocumentRequestsAPI.addSigner(dataForm.value)
        .then((res) => {
            // signers.value = res;
            closeModal();
            toast.success("Se ha agragado corectamente", {
            timeout: 2000,
            });
        })  
        .catch(error => 
            toast.warning("No se ha podido Agregar", {
            timeout: 2000,
            })
        );
    }

    function resetData(){
        formData.value.email = null;
        formData.value.name = "";
        formData.value.document_id = "";  
    }

    function addSigner(){
        emit('add')
        v$._value.$reset();
    }

    function closeModal(){
        v$._value.$reset();
        resetData();
        emit('cancel');
    }
    </script>