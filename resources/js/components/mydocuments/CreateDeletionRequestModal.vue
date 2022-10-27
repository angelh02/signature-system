<template>
    <div>
        <div class="modal fade" id="deletion-request-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Solicitud de cancelación</h5>
                    </div> <!-- end modal header -->
                    <div class="modal-body">
                        <!-- Asunto del mensaje -->
                        <div class="mb-2">
                            <label for="subject" class="form-label">
                                Asunto
                            </label>
                            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                <input
                                    type="text"
                                    id="subject"
                                    class="form-control"
                                    v-model="v$.subject.$model"
                                    placeholder="Asunto..."
                                    maxlength="255"
                                />
                                <div v-for="(error, index) in v$.subject.$errors" :key="index" class="invalid-feedback d-block">
                                    {{ error.$message }}
                                </div>
                            </div>
                        </div>
                        <!-- Contenido del mensaje -->
                        <div class="write-mdg-box mb-3">
                            <label for="description" class="form-label">
                                Mensaje
                            </label>
                            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                <textarea
                                    class="form-control"
                                    id="description"
                                    style="resize: none;"
                                    v-model="v$.description.$model"
                                    placeholder="Escribe algo..."
                                    rows="6"
                                ></textarea>
                                <div v-for="(error, index) in v$.description.$errors" :key="index" class="invalid-feedback d-block">
                                    {{ error.$message }}
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cancel">CANCELAR</button>
                        <button type="button" class="btn btn-primary" @click="storeRequest" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">ENVIAR</button>
                    </div> <!-- end modal footer -->
                </div> <!-- end modal content-->
            </div> <!-- end modal dialog-->
        </div>
    </div>
</template>
<script setup>
import { ref, toRef, onMounted, reactive} from 'vue';
import $ from "jquery";
import { useVuelidate } from '@vuelidate/core'
import { required, email ,minValue, helpers, minLength, maxLength} from '@vuelidate/validators'
import {useToast} from "vue-toastification";
import useFileDeletionRequestAPI from "@/api/admin/deletion-request/index.js";

const emit = defineEmits(['cancel', 'stored']);

const toast = useToast();

const props = defineProps({
    documentId: Number,
});

const documentId = toRef(props, 'documentId');

const requestData = ref({
    subject : "",
    description : ""
})
const rules = {
    subject: {
    required: helpers.withMessage('Este campo no debe estar vacio', required),
    minLength: helpers.withMessage('Minimo debe ser 10 caracter', minLength(10)),
    maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
    },
    description: {
    required: helpers.withMessage('Este campo no debe estar vacio', required),
    minLength: helpers.withMessage('Minimo debe ser 10 caracteres', minLength(10)),
    },
};
const state = reactive(requestData);
const v$ = useVuelidate(rules, requestData);

function cancel(){
    requestData.value = {
        subject : "",
        description : ""
    }
    v$._value.$reset();
    emit("cancel");
}

function storeRequest(){
    if(v$.$errors.length > 0 || v$.$silentErrors.length > 0){
        let data = {
            document_id : documentId.value,
            subject : requestData.subject.value,
            description : requestData.description.value
        }
        useFileDeletionRequestAPI.store(formData.value)
        .then((res) => {
            toast.success("Se ha agragado corectamente", {
            timeout: 2000,
            });
            emit('stored');
        })
        .catch(error => 
            toast.warning("No se ha podido Agregar", {
            timeout: 2000,
            })
        );
    }
}
</script>