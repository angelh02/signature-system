<template>
<div class="modal fade" id="request-info-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detalles de la solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="card tilebox-one">
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center text-bg-primary">
                                        INFORMACIÓN GENERAL
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Folio: {{formData.id}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Asunto: {{formData.subject}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Descripción: {{formData.description}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Estado: {{formData.status}}
                                    </li>
                                </ul>
                            </div> 
                        </div>
                    </div>

                    <div class="col">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center modal-title text-bg-primary">
                                        INFORMACIÓN DEL DOCUMENTO
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Nombre: {{formData.document.name}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Nombre de usuario: {{formData.document.user.name}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Apellido de usuario: {{formData.document.user.surnames}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Nick de usuario: {{formData.document.user.user_name}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center h5">
                                        Email: {{formData.document.user.email}}
                                    </li>
                                </ul>    
                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</template>
<script setup>
import { ref, toRef, onMounted, reactive} from 'vue';
import { Modal, Popover } from "bootstrap";

const emit = defineEmits(["cancel"]);

const props = defineProps({
    formData: Object,
    tab: String
});

//ReadOnly
const formData = toRef(props, 'formData');
const tab = toRef(props, 'tab');


function closeModal(){
    emit('cancel');
}
</script>