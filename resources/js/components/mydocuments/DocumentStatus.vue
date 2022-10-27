<template>
    <div class="px-4">
        <div class="page-title-box">
            <h1 class="page-title">Estado actual del documento</h1>
        </div>
        <p>
            En esta página puedes consultar el estado del documento y cada uno  de sus firmantes en tiempo real, junto con información detallada sobre el documento y las personas que ya han firmado.
        </p>
        <h4>
            <span :class="'badge border border-light rounded-circle p-1 bg-'+(documentData.signed == 0  ? 'warning' : 'success') ">
                <i :class="(documentData.signed == 0 ? 'dripicons-clock' : 'dripicons-checkmark')"></i>
            </span>
            {{documentData.signed == 0 ? "Documento con firmas pendientes" : "Documento firmado"}}
        </h4>
        <div class="mt-3">
            <h4>Sobre el documento</h4>
            <div class="card border-secondary border mt-3">
                <div class="card-body p-2">
                    <table class="table table-sm table-borderless mb-0">
                        <col width=100><col width=100><col width=100>
                        <tbody>
                            <tr>
                                <td colspan="1">Nombre del documento: </td>
                                <td colspan="2">{{documentData.name}}</td>
                            </tr>
                            <tr>
                                <td>Tipo de documento: </td>
                                <td>{{documentData.document_type?.name}}</td>
                            </tr>
                            <tr>
                                <td>Clasificación: </td>
                                <td>{{documentData.classification?.name}}</td>
                            </tr>
                            <tr>
                                <td>Contenedor: </td>
                                <td>{{documentData.container?.name}}</td>
                            </tr>
                            <tr>
                                <td>Fecha de creación: </td>
                                <td>{{documentData.created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <h4>Sobre el los firmantes</h4>
            <p>
                En esta sección  puedes consultar el estado de cada una de las firmas requeridas. En caso de que el firmante ya haya firmado podrás visualizar sus datos, su firma y la fecha en la que firmó.
            </p>
            <div class="card border-secondary border mt-3" v-if="documentData?.document_signers?.length > 0">
                <div class="card-body p-2">
                    <table class="table table-sm table-borderless mb-0">
                        <col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100>
                        <tbody>
                            <tr v-for="signer in documentData?.document_signers">
                                <td colspan="1"><p class="m-0"><span :class="'badge bg-'+(signer.signed == 0 ? 'warning' : 'success')">{{signer.signed == 0 ? 'Pendiente' : 'Firmado'}}</span></p></td>
                                <td colspan="2">{{signer.email}}</td>
                                <td colspan="2">{{signer.name+" "+signer.surnames}}</td>
                                <td colspan="2" v-if="signer.signed == 1">Firmado: {{signer.signed_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, toRefs, toRef, reactive } from "vue";
import $ from "jquery";
import { integer } from "@vuelidate/validators";
import {useRoute} from 'vue-router';
import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentsRequest.js";

const route = useRoute()
const documentId = ref(0);

//Extract functions about requests
const { getDocument } =
    useDocumentsRequests();

//Document
const documentData = ref("");

onMounted(async () => {
    documentId.value = parseInt(route.params.id);
    searchDocument();
});

const searchDocument = async () => {
    documentData.value = await getDocument(documentId.value);
};
</script>