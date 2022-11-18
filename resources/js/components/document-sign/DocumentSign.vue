<template>
    <div class="container p-3 pt-2">
        <div class="row" v-if="!submited">
            <div class="col-4">
                <div class="card border border-1 shadow p-3 mb-3 bg-body rounded pt-0 ps-0 pe-0">
                    <div class="card-header p-0">
                        <ul class="nav nav-pills bg-nav-pills nav-justified">
                            <li class="nav-item">
                                <a @click="changeTab(1)" type="button" id="tab-pdf" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Revisa</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a @click="changeTab(2)" type="button" id="tab-sign" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Firma</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pb-2">
                        <div class="tab-content">
                            <div class="tab-pane" id="card-pdf">
                                <p>
                                    Revisa el documento y cuando estés listo, da
                                    clic en el botón “Continuar a firmar”. Si hay una
                                    que te impida hacerlo, da clic en enlace “Hay un
                                    problema con el documento”
                                </p>
                                <div class="text-center mb-3">
                                    <a class="btn btn-primary" style="width: 80%;" @click="changeTab(2)">CONTINUAR A FIRMAR</a>
                                </div>
                                <a v-if="documentData?.user_id != userLogged.id" type="button" class="text-primary" @click="openContactModal">Hay un problema con el documento</a>
                            </div>
                            <div class="tab-pane" id="card-sign">
                                <p>
                                    Para firmar, necesitarás los archivos de tú e.firma (anteriormente FIEL).
                                </p>
                                <p>
                                    Los datos sensibles de tú e.firma
                                    <b>nunca se comparten con esta plataforma.</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Info documento -->
                <div class="card border border-1 shadow p-3 mb-3 bg-body rounded pt-0 ps-0 pe-0">
                    <div class="card-body">
                        <p><b>Documento</b></p>
                        <div class="inbox-widget" v-if="documentData != null">
                            <div class="inbox-item">
                                <div class="inbox-item-img"><i class="mdi mdi-48px mdi-file-document-outline"></i></div>
                                <p class="inbox-item-author">{{documentData?.name}}</p>
                                <p class="inbox-item-text">Creado el {{documentData?.created_at}}</p>
                                <a type="button" class="text-primary" @click="viewDocument(documentData?.aws_document_id)" style="font-size: 0.8125rem">Descargar</a>
                            </div>
                            <div class="inbox-item">
                                <p class="inbox-item-author">Tipo de documento</p>
                                <p class="inbox-item-text">{{documentData?.document_type?.code+' - '+documentData?.document_type?.name}}</p>
                            </div>
                            <div class="inbox-item">
                                <p class="inbox-item-author">Clasificación del documento</p>
                                <p class="inbox-item-text">{{documentData?.classification?.name}}</p>
                            </div>
                            <div class="inbox-item">
                                <p class="inbox-item-author">Contenedor del documento</p>
                                <p class="inbox-item-text">{{documentData?.container?.name}}</p>
                            </div>
                        </div>
                        <p class="pt-2 pb-1 m-0"><b>Estado del documento</b></p>
                        <p class="pb-1 m-0" style="font-size: 0.8125rem">
                            Para revisar las firmas solicitadas para este
                            documento y el estado actual de cada una, haz
                            clic en el siguiente enlace.
                        </p>
                        <router-link :to="`/mis-documentos/estado/${documentData?.id}`" target="_blank" style="font-size: 0.8125rem">Estado actual del documento</router-link>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="tab-content">
                    <div class="tab-pane" id="pdf-viewer">
                        <div class="tab-pane" id="profile1">
                            <div
                                class="card bg-secondary text-white rounded m-0"
                                style="background-color: #a1a5ad"
                            >
                                <div class="d-flex justify-content-between pe-2 ps-2 pt-1 pb-1" v-if="documents?.length > 1">
                                    <span class="align-middle">
                                        <button class="btn btn-light btn-sm p-0 me-1" :disabled="pdfIndex <= 1" @click="pdfIndex--">
                                            <i class="uil uil-angle-left fs-5"></i>
                                        </button>
                                        {{pdfIndex}} / {{documents?.length}}
                                        <button class="btn btn-light btn-sm p-0 ms-1" :disabled="pdfIndex >= documents?.length" @click="pdfIndex++">
                                            <i class="uil uil-angle-right fs-5"></i>
                                        </button>
                                    </span>
                                    <label class="align-middle">
                                        {{documentData?.name}}
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center" style="height: 50vh;" v-if="!pdfLoaded">
                                <div class="spinner-border mt-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
                            </div>
                            <div
                                class="card bg-secondary text-white rounded"
                                :class="pdfLoaded ? 'd-block':'d-none'"
                                style="background-color: #a1a5ad"
                            >
                                <VuePdfEmbed
                                    ref="pdfViewer"
                                    :source="source"
                                    :key="source"
                                    @rendered = "handleDocumentRender"
                                    class="scrollspy-example"
                                ></VuePdfEmbed>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="sign-form">
                        <div v-if="certificatesExist">
                            <div class="d-flex ms-3">
                                <i class="uil uil-file-check-alt me-2 font-24 text-success"></i>
                                <div>
                                    <a class="mt-3 font-18" href="javascript:void(0);">
                                        <strong class="text-success">Certificados Activos:</strong>
                                        <span class="text-muted">
                                            Tus certificados se validaron exitosamente, ahora puedes firmar {{documents?.length > 1 ? "tus documentos":"tu documento"}}.<br>
                                            Por favor, revisa que {{documents?.length > 1 ? "tus documentos estén correctos antes de firmarlos":"tu documento este correcto antes de firmarlo"}}.
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" @click="signDocument" :disabled="submit || !certificatesExist" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="submit"></span>
                                    FIRMAR {{documents?.length > 1 ? "DOCUMENTOS":"DOCUMENTO"}}
                                </button>
                            </div>
                        </div>
                        <div v-else>
                            <div class="accordion custom-accordion" id="custom-accordion-one">
                                <div class="card mb-0">
                                    <div class="card-header" id="cer-file">
                                        <h5 class="m-0">
                                            <a id="up-cer-btn" class="custom-accordion-title d-block py-1"
                                                data-bs-toggle="collapse" href="#up-cer"
                                                aria-expanded="true" aria-controls="up-cer">
                                                1. Selecciona el certificado (archivo .cer) <i
                                                    class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                        
                                    <div id="up-cer" class="collapse show"
                                        aria-labelledby="cer-file"
                                        data-bs-parent="#up-cer">
                                        <div class="card-body">
                                            <div>
                                                <DropZone :title="'Arrastra tu documetos cer en la página o'" :acceptedFiles="'.cer'" @onDrop="onDropCerFile"></DropZone>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-0">
                                    <div class="card-header" id="key-file">
                                        <h5 class="m-0">
                                            <a id="up-key-btn" class="custom-accordion-title collapsed d-block py-1"
                                                data-bs-toggle="collapse" href="#up-key"
                                                aria-expanded="false" aria-controls="up-key">
                                                2. Selecciona la llave privada (archivo .key) <i
                                                    class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="up-key" class="collapse"
                                        aria-labelledby="key-file"
                                        data-bs-parent="#custom-accordion-one">
                                        <div class="card-body">
                                            <div>
                                                <DropZone :title="'Arrastra tu documetos key en la página o'" :acceptedFiles="'.key'" @onDrop="onDropKeyFile"></DropZone>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-0">
                                    <div class="card-header" id="password-form">
                                        <h5 class="m-0">
                                            <a id="password-btn" class="custom-accordion-title collapsed d-block py-1"
                                                data-bs-toggle="collapse" href="#password-tab"
                                                aria-expanded="false" aria-controls="password-tab">
                                                3. Ingresa la contraseña de tu e.firma <i
                                                    class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="password-tab" class="collapse" aria-labelledby="password-form"
                                        data-bs-parent="#custom-accordion-one">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">Ingresa tu contraseña:</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password" class="form-control " name="password" required="" autocomplete="current-password" placeholder="Introduce tu contraseña" v-model="signData.password">
                                                    <button id="password-type" class="input-group-text" @click="changeInputText">
                                                        <span class="password-eye"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" @click="submitCertificates" :disabled="submit || signData.password == '' || signData.cer_file == '' || signData.key_file == ''" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="submit"></span>
                                    SUBIR DOCUMENTOS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <DocumentSigned v-if="submited"></DocumentSigned>
        <ContactModal
            :document-id="documentData?.id"
            :user="documentData?.user"
            :modalId="'contact-modal'"
            @cancel="cancelModal"
            @stored="acceptModal"
        >
        </ContactModal>
    </div>
</template>
<script setup>
    import DocumentUpload from "../elements/DropZone.vue";
    import ContactModal from "../elements/MessageContacModal.vue";
    import $ from 'jquery';
    import { Modal } from "bootstrap";  
    import {useToast} from "vue-toastification";
    import CryptoJS from 'crypto-js';
    import { ref, onMounted, watch, toRefs, toRef, reactive, useAttrs } from "vue";
    import VuePdfEmbed from 'vue-pdf-embed';
    import DocumentSigned from "./DocumentSigned.vue";
    import DropZone from "../elements/DropZone.vue";
    import { useRouter, useRoute } from "vue-router";
    import { useDocumentsRequests } from "@/js/composables/document-apis/useDocumentsRequest.js";
    import useDocumentsRequestsAPI from "@/api/document/index.js";
    import useSignRequestsAPI from "@/api/sign-document/index.js";

    const toast = useToast();
    
    const attrs = useAttrs();
    const userLogged = ref(attrs.user);
    const certificatesExist = ref(false);

    const router = useRouter();
    const route = useRoute();

    //Get ids from params
    const documentsIds = ref(JSON.parse(route.params.ids).documents);
    const source = ref("");
    const pdfViewer = ref(null);
    const pdfLoaded = ref(false);
    //Const to count pdf files
    const pdfIndex = ref(1);

    //Extract functions about requests
    const { getDocumentsByIds } =
        useDocumentsRequests();

    //Const to steps form
    const step = ref(0);

    //Dropzone
    const dataFile = ref("");

    //Modal
    const contactModal = ref({});

    //Subir info
    const submit = ref(false);
    const submited = ref(false);
    const documents = ref([]);
    const documentData = ref(null);
    const documentDownload = ref("");
    const signData = ref({
        user_id : 0,
        documents : [],
        cer_file : "",
        key_file : "",
        password : ""
    });

    onMounted(async () => {
        searchDocuments();
        checkCertificates();
        $("#tab-pdf").addClass("active");
        $("#pdf-viewer").addClass("show active");
        $("#card-pdf").addClass("show active");
    });

    //Watchers
    watch(
        () => pdfLoaded,
        (pdfLoaded, oldPdfLoaded) => {
            if(pdfLoaded){
                refreshPdfViewer();
            }
        },
        {deep:true}
    );
    watch(
        () => pdfIndex,
        (pdfIndex, oldPdfIndex) => {
            pdfLoaded.value = false;
            source.value = "";
            documentData.value = documents.value[pdfIndex.value-1];
            setTimeout(function () {
                refreshPdf(documentData.value.id);
            }, 1000);
        },
        {deep:true} 
    );

    //Modal functions
    //Functions
    function cancelModal(){
        contactModal.value.hide();
    }

    function acceptModal(){
        contactModal.value.hide();
    }

    function openContactModal(){
        contactModal.value.show();
    }

    async function checkCertificates(){
        await useSignRequestsAPI.checkCertificates({
                aws_token : userLogged.value.aws_auth_token
            })
            .then(data => {
                if(data.status == 0)
                    certificatesExist.value = false;
                else
                    certificatesExist.value = true;
            });
    }

    function changeInputText(){
        if($('#password').attr('type') == 'password')
            $('#password-type').addClass("show-password");
        else
            $('#password-type').removeClass("show-password");
        $('#password').attr('type', $('#password').attr('type') == 'text' ? 'password' : 'text');
        
    }

    function changeTab(tab){
        if(tab == 1){
            $("#tab-sign").removeClass("active");
            $("#sign-form").removeClass("show active");
            $("#card-sign").removeClass("show active");
            $("#tab-pdf").addClass("active");
            $("#pdf-viewer").addClass("show active");
            $("#card-pdf").addClass("show active");
        }
        else{
            $("#tab-pdf").removeClass("active");
            $("#pdf-viewer").removeClass("show active");
            $("#card-pdf").removeClass("show active");
            $("#tab-sign").addClass("active");
            $("#sign-form").addClass("show active");
            $("#card-sign").addClass("show active");
        }
    }

    async function encryptPassword(password){
        let keyData = await useSignRequestsAPI.getUploadCertificateKey({aws_token : userLogged.value.aws_auth_token});

        let key = CryptoJS.enc.Utf8.parse(
            keyData.uuid.slice(0, 16).toUpperCase()
        );
        let iv = CryptoJS.enc.Utf8.parse(
            keyData.data.iv.slice(0, 16).toUpperCase()
        );
        let Epassword = CryptoJS.AES.encrypt(
            CryptoJS.enc.Utf8.parse(password),
            key,
            {
                keySize: 128 / 8,
                iv: iv,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7,
            }
        ).toString();
        return {password : Epassword, idRequest : keyData.data.id};
    }

    function getBase64String(file, onLoadCallback) {
        return new Promise(function(resolve, reject) {
            var reader = new FileReader();
            reader.onload = function() { resolve(reader.result); };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    //Events to pdf viewer
    function handleDocumentRender() {
        pdfLoaded.value = true;
    };

    function handlePasswordRequest(callback, retry) {
        callback(prompt(retry
        ? 'Enter password again'
        : 'Enter password'
        ))
    };

    async function viewDocument(documentId){
        let url = await useSignRequestsAPI.getDocumentBase(documentId, userLogged.value.aws_auth_token);
        window.open(url, '_blank');
    }

    //Functions to dropzone
    async function onDropCerFile(acceptFiles) { 
        let promise = getBase64String(acceptFiles[0]);
        signData.value.cer_file = acceptFiles[0];
        step.value = 1;  
        $("#up-cer-btn").attr('aria-expanded', "false");
        $("#up-cer-btn").addClass("collapsed");
        $("#up-cer").removeClass("show");
        $("#up-key-btn").attr('aria-expanded', "true");
        $("#up-key-btn").removeClass("collapsed");
        $("#up-key").addClass("show");
        $("#password-btn").attr('aria-expanded', "false");
        $("#password-btn").addClass("collapsed");
        $("#password-tab").removeClass("show");
    }

    async function onDropKeyFile(acceptFiles) {
        let promise = getBase64String(acceptFiles[0]);
        signData.value.key_file = acceptFiles[0];
        step.value = 2;
        $("#up-key-btn").attr('aria-expanded', "false");
        $("#up-key-btn").addClass("collapsed");
        $("#up-key").removeClass("show");
        $("#password-btn").attr('aria-expanded', "true");
        $("#password-btn").removeClass("collapsed");
        $("#password-tab").addClass("show");
        $("#up-cer-btn").attr('aria-expanded', "false");
        $("#up-cer-btn").addClass("collapsed");
        $("#up-cer").removeClass("show");
    }

    async function refreshPdf(documentId){
        source.value = await useSignRequestsAPI.getDocumentBase(documentId, userLogged.value.aws_auth_token);
        pdfViewer.value.$.props.source = source.value;
        refreshPdfViewer();
    }

    const refreshPdfViewer = async () => {
        await Promise.resolve(pdfViewer.value.render());
    };

    const searchDocuments = async () => {
        documents.value = await getDocumentsByIds({documents : documentsIds.value});
        documentData.value = documents.value[0];
        pdfLoaded.value = false;
        source.value = "";
        signData.value.documents = [...documents.value.map(x => x.id)];
        signData.value.user_id = userLogged.value.id;
        contactModal.value = new Modal($("#contact-modal"));
        setTimeout(function () {
            refreshPdf( documentData.value.aws_document_id);
        }, 3000);
    };

    const submitCertificates = async () => {
        if(signData.value.cer_file != "" && signData.value.key_file != "" && signData.value.password != "")
        {
            submit.value = true;
            let encryptData = await encryptPassword(signData.value.password);
            //console.log("🚀 ~ file: DocumentSign.vue ~ line 458 ~ submitCertificates ~ encryptData", encryptData)
            let data = new FormData();
            data.append('filecer', signData.value.cer_file);
            data.append('fileKey', signData.value.key_file);
            //console.log("🚀 ~ file: DocumentSign.vue ~ line 468 ~ submitCertificates ~ signData.value", signData.value)
            await useSignRequestsAPI.submitCertificates(userLogged.value.aws_auth_token, encryptData.password, encryptData.idRequest, data)
                .then(res => {
                    submit.value = false;
                    checkCertificates();
                })
                .catch(e => {
                    //console.log("🚀 ~ file: DocumentSign.vue ~ line 474 ~ submitCertificates ~ e", e)
                    toast.warning("No se ha podido Agregar los documentos", {
                        timeout: 2000,
                    })
                })
        }
    }

    const signDocument = async () => {
        if(certificatesExist.value)
        {
            submit.value = true;
            //console.log("🚀 ~ file: DocumentSign.vue ~ line 428 ~ signDocument ~ signData.value", signData.value)
            useDocumentsRequestsAPI.signDocument({
                aws_token : userLogged.value.aws_auth_token,
                user_id : userLogged.value.id,
                documents : documentsIds.value,
            })
            .then((res) => {
                setTimeout(function() {
                    submit.value = false;
                    submited.value = true;
                    step.value = 0;
                }, 3000);
            });
        }
    };
</script>