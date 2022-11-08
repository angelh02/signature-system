<template>
    <div>
        <div v-if="!documentCreated">
            <div class="row">
                <div class="col-8">
                    <div class="row mx-2">
                        <div class="col-7 p-0">
                            <h3>Preparación de documento</h3>
                        </div>
                        <div class="col-5 py-2 pe-0">
                            <ul
                                class="nav nav-pills bg-nav-pills nav-justified"
                            >
                                <li class="nav-item">
                                    <a
                                        href="#signers"
                                        data-bs-toggle="tab"
                                        aria-expanded="false"
                                        class="nav-link rounded-0 active"
                                    >
                                        <i
                                            class="mdi mdi-home-variant d-md-none d-block"
                                        ></i>
                                        <span class="d-none d-md-block"
                                            >Preparación</span
                                        >
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="#document"
                                        data-bs-toggle="tab"
                                        aria-expanded="true"
                                        class="nav-link rounded-0"
                                    >
                                        <i
                                            class="mdi mdi-account-circle d-md-none d-block"
                                        ></i>
                                        <span class="d-none d-md-block"
                                            >Documento</span
                                        >
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content mx-2">
                        <div class="tab-pane my-lg-n4 pt-3" id="document">
                            <div
                                class="mt-3"
                            >
                                <div
                                    class="card-body"
                                >
                                    <div
                                        class="card bg-secondary text-white rounded m-0"
                                        style="background-color: #a1a5ad"
                                    >
                                        <div class="d-flex justify-content-between pe-2 ps-2 pt-1 pb-1" v-if="dataDocuments?.files.length > 1">
                                            <span class="align-middle">
                                                <button class="btn btn-light btn-sm p-0 me-1" :disabled="pdfIndex <= 1" @click="pdfIndex--">
                                                    <i class="uil uil-angle-left fs-5"></i>
                                                </button>
                                                {{pdfIndex}} / {{dataDocuments?.files.length}}
                                                <button class="btn btn-light btn-sm p-0 ms-1" :disabled="pdfIndex >= dataDocuments?.files.length" @click="pdfIndex++">
                                                    <i class="uil uil-angle-right fs-5"></i>
                                                </button>
                                            </span>
                                            <label class="align-middle">
                                                {{dataDocuments?.files[pdfIndex-1]?.name}}
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
                                </div><!-- end card-body-->
                            </div>
                        </div>
                        <!-- Firmantes -->
                        <div class="tab-pane active my-xxl-n4" id="signers">
                            <h5>Añadir participantes</h5>
                            <div class="pt-2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a
                                            href="#signer-form"
                                            data-bs-toggle="tab"
                                            aria-expanded="false"
                                            class="nav-link rounded-bottom rounded-3 active"
                                            style="background-color: #a1a5ad"
                                        >
                                            <i
                                                class="mdi mdi-home-variant d-md-none d-block"
                                            ></i>
                                            <span class="d-none d-md-block text-white"
                                                >Firmantes</span
                                            >
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card" style="background-color: #e9e9e9;">
                                <div class="card-body">
                                    <form class="needs-validation"  novalidate>
                                        <div class="card mb-2" >
                                        <div class="row g-2 card-body" style="background-color: #f7f7f7;" v-if="users.length > 0">
                                            <div class="mb-3 col-6">
                                                <label class="form-label"
                                                    >NOMBRE COMPLETO</label
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
                                        </div>
                                        
                                    </div>
                                    <button
                                            class="btn btn-sm btn-link p-1"
                                            type="button"
                                            @click="addSigner"
                                            :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0"
                                        >
                                        <h4 class="uil-plus-circle">Añadir firmante</h4>
                                            
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card" v-if="signers?.length > 0">
                                <div class="card-body pb-0">
                                    <h4 class="header-title mb-3">FIRMANTES</h4>

                                    <div class="inbox-widget mb-3">
                                        <div class="inbox-item" v-for="signer in signers">
                                            <p class="inbox-item-author">{{signer.name}} {{signer.surnames}}</p>
                                            <p class="inbox-item-text">{{signer.email}}</p>
                                            <p class="inbox-item-date">
                                                <button type="button" @click="deleteSigner(signer.id)" class="btn btn-sm btn-outline-danger px-1 py-0"> <i class="uil uil-trash-alt font-16"></i> </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4 row justify-content-center py-2">
                    <div class="">
                        <div class="card rounded-4 border border-start">
                            <div class="card-body">
                                <p><b>Documento</b></p>
                                <div class="inbox-widget mb-2">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><i class="mdi mdi-48px mdi-file-document-outline"></i></div>
                                        <p class="inbox-item-author">{{dataDocuments?.files[pdfIndex-1].name}}</p>
                                        <p class="inbox-item-text">Será creado el {{actualDate}}</p>
                                        <p style="font-size: 0.8125rem">Tipo de archivo PDF</p>
                                    </div>
                                    <div class="inbox-item">
                                        <p class="inbox-item-author">Tipo de documento</p>
                                        <p class="inbox-item-text">{{dataDocuments?.document_type.code+' - '+dataDocuments?.document_type.name}}</p>
                                    </div>
                                    <div class="inbox-item">
                                        <p class="inbox-item-author">Clasificación del documento</p>
                                        <p class="inbox-item-text">{{dataDocuments?.classification?.name}}</p>
                                    </div>
                                    <div class="inbox-item">
                                        <p class="inbox-item-author">Contenedor del documento</p>
                                        <p class="inbox-item-text">{{dataDocuments?.container?.name}}</p>
                                    </div>
                                    <div class="inbox-item">
                                        <p class="inbox-item-author"><b>¿Documento firmado por mí?</b></p>
                                        <p class="inbox-item-text">Al finalizar, se firmará el documento</p>
                                        <p class="inbox-item-date">
                                            <input type="checkbox" id="signed_switch" data-switch="primary" v-model="userSign"/>
                                            <label for="signed_switch" data-on-label="SI" data-off-label="NO"></label>
                                        </p>
                                    </div>
                                </div>
                                <div class="row justify-items-center ps-2 pe-2">
                                    <button
                                        class="btn btn-primary mb-2"
                                        type="button"
                                        @click="createDocument"
                                        :disabled="(signers.length == 0 && !userSign) || loadDocuments"
                                    >
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="loadDocuments"></span>
                                        SOLICITAR FIRMAS
                                    </button>
                                    <router-link class="btn btn-light mb-2" type="button" :to="'/mis-documentos'">CANCELAR</router-link>
                                </div>
                            </div>
                            <!-- end card-body-->
                        </div>
                        <!-- end card-->
                    </div>
                </div>
            </div>
        </div>
        <DocumentCreated v-else></DocumentCreated>
    </div>
</template>

<script setup>
    //Libraries
    import { ref, onMounted, watch, toRef, reactive, useAttrs } from "vue";
    import $ from 'jquery';
    import select2 from "select2";
    import moment from "moment";
    import { useRouter, useRoute } from "vue-router";
    import VuePdfEmbed from 'vue-pdf-embed';
    import { useVuelidate } from '@vuelidate/core';
    import { required, numeric ,minValue, helpers, minLength, maxLength} from '@vuelidate/validators';
    //API Functions
    import useUserRequestsApi from "@/api/admin/user/index.js"
    import useDocumentRequestsAPI from "@/api/document/index.js";
    import DocumentCreated from "./DocumentCreated.vue";

    const attrs = useAttrs();
    const userLogged = ref(attrs.user);

    const actualDate = ref(moment().locale('es-mx').format('L'));
    const userSign = ref(false);

    const router = useRouter();
    const route = useRoute();
    const formData = ref({
        name: "",
        email: "",
        document_id: 0,
    });
    const documentId = ref(0);
    const documentData = ref({});
    const documentCreated = ref(false);
    const loadDocuments = ref(false);
    const documentDownload = ref("");

    //Pdf viewer consts
    const dataDocuments = ref(JSON.parse(route.params.files));
    const source = ref(dataDocuments.value.files[0].data);
    const pdfViewer = ref(null);
    const pdfLoaded = ref(false);
    //Const to count pdf files
    const pdfIndex = ref(1);

    const data = ref("");

    //select 2 info
    const users = ref([]);
    const userSelected = ref({});
    const signers = ref([]);

    //Vuelidate conts
    const userForm = ref({
        id : "",
        email : ""
    });
    const rules = {
        id : {required: helpers.withMessage('Debes seleccionar una opción', required),},
        email : {
            required: helpers.withMessage('Este campo no debe estar vacio', required)
        },
    };
    const state = reactive(userForm);
    const v$ = useVuelidate(rules, userForm);

    //Life cycle
    onMounted(async () => {
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
                templateSelection: userSelect
            });
        });
        getRequest();
        pdfLoaded.value = false;
        source.value = "";
        setTimeout(function () {
            refreshPdf(dataDocuments.value.files[pdfIndex.value-1].data);
        }, 3000);
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
            setTimeout(function () {
                refreshPdf(dataDocuments.value.files[pdfIndex.value-1].data);
            }, 1000);
        },
        {deep:true} 
    );

    //Methods
    function addSigner(){
        signers.value.push(userSelected.value);
        v$._value.id.$model = "";
        v$._value.email.$model = "";
        v$._value.$reset();
        refreshSelect();
    }

    const addRequest = async => {
        console.log(formData.value)
        useDocumentRequestsAPI.addSigner(formData.value)
        .then((res) => {
            signers.value = res;
            resetData();
        });
        // resetData();
    }

    const createDocument = asyc => {
        let signerList = [...signers.value];
        if(userSign.value)
            signerList.push(userLogged.value);
        if(signerList.length > 0){
            let data = {
                user_id : userLogged.value.id,
                documents : [...dataDocuments.value.files],
                signers : [...signerList.map(x => ({
                    user_id : x.id,
                    email : x.email,
                    name : x.name,
                    surnames : x.surnames
                }))],
                container_id : dataDocuments.value.container.id,
                classification_id : dataDocuments.value.classification.id,
                document_type_id : dataDocuments.value.document_type.id
            };
            console.log("🚀 ~ file: DocumentsPreparation.vue ~ line 398 ~ createDocument ~ data", data)
            loadDocuments.value = true;
            useDocumentRequestsAPI.addDocument(data)
            .then((res) => {
                console.log("🚀 ~ file: DocumentsPreparation.vue ~ line 412 ~ .then ~ res", res)
                loadDocuments.value = false;
                if(userSign.value){
                    let ids = JSON.stringify({documents : res.map(x => x.id)});
                    console.log("🚀 ~ file: DocumentsPreparation.vue ~ line 398 ~ .then ~ ids", ids)
                    router.push({
                        name : 'DocumentSign',
                        params: {ids: ids}
                    });
                }
                else
                    documentCreated.value = true;
            });
        }
    }

    function deleteSigner(id){
        signers.value = signers.value.filter(x => x.id != id);
        v$._value.id.$model = "";
        v$._value.email.$model = "";
        v$._value.$reset();
        refreshSelect();
    }

    const getRequest = async () => {
        //get all users
        let usersList = await useUserRequestsApi.getAll();
        users.value = usersList.filter(x => x.roles[0].name != "Administrador" && userLogged.value.id != x.id);
        refreshSelect();
    }

    function handleDocumentRender(){
        pdfLoaded.value = true;
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
                templateSelection: userSelect
            });
        });
    }

    function refreshPdf(result){
        source.value = result;
        pdfViewer.value.$.props.source = source.value;
        refreshPdfViewer();
    }

    const refreshPdfViewer = async () => {
        await Promise.resolve(pdfViewer.value.render());
    };

    function resetData(){
        formData.value.email = null;
        formData.value.name = "";
        formData.value.document_id = "";  
    }

    function userEnable(userId){
        if(signers.value.length == 0 || (signers.value.length > 0 && signers.value.findIndex(x => x.id == userId) == -1))
            return true;
        return false;
    }
</script>
