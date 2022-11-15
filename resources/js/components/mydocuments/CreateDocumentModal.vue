<template>
    <div>
        <div id="create-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-full-width">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8">
                                <div
                                    class="card bg-secondary text-white rounded m-0"
                                    style="background-color: #a1a5ad"
                                >
                                    <div class="d-flex justify-content-between pe-2 ps-2 pt-1 pb-1" v-if="dataFiles.length > 1">
                                        <span class="align-middle">
                                            <button class="btn btn-light btn-sm p-0 me-1" :disabled="pdfIndex <= 1" @click="pdfIndex--">
                                                <i class="uil uil-angle-left fs-5"></i>
                                            </button>
                                            {{pdfIndex}} / {{dataFiles.length}}
                                            <button class="btn btn-light btn-sm p-0 ms-1" :disabled="pdfIndex >= dataFiles.length" @click="pdfIndex++">
                                                <i class="uil uil-angle-right fs-5"></i>
                                            </button>
                                        </span>
                                        <label class="align-middle">
                                            {{dataFiles[pdfIndex-1]?.path}}
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center h-50" v-if="!pdfLoaded">
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
                            <div
                                class="col-4 row mx-0 justify-content-center"
                            >
                                <div class="border-start">
                                    <div class="card-header">
                                        <h2>Preparación del documento</h2>
                                    </div>
                                    <div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label
                                                    class="form-label"
                                                    for="validationCustom06"
                                                    >NOMBRE DEL
                                                    DOCUMENTO</label
                                                >
                                                <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                                    <input
                                                        ref="nameInput"
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        placeholder="Ingrese Nombre"
                                                        maxlength="30"
                                                        v-model="v$.name.$model"
                                                        :disabled="true"
                                                        required
                                                    />
                                                    <div v-for="(error, index) in v$.name.$errors" :key="index" class="invalid-feedback d-block">
                                                        {{ error.$message }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label"
                                                    for="background_id"
                                                    >TIPO DE
                                                    DOCUMENTO</label
                                                >
                                                <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                                    <select
                                                        v-model="
                                                            v$.document_type_id.$model
                                                        "
                                                        class="form-select"
                                                        id="background_id"
                                                        name="background_id"
                                                        required
                                                    >
                                                        <option
                                                            :value="''"
                                                            selected
                                                        >
                                                            Selecciona una
                                                            opción...
                                                        </option>
                                                        <option
                                                            v-for="res in documentTypes"
                                                            :value="res.id"
                                                        >
                                                            {{ `${res.code}` }}
                                                            -
                                                            {{ `${res.name}` }}
                                                        </option>
                                                    </select>
                                                    <div v-for="(error, index) in v$.document_type_id.$errors" :key="index" class="invalid-feedback d-block">
                                                        {{ error.$message }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label"
                                                    for="background_id"
                                                    >CLASIFICACIÓN</label
                                                >
                                                <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                                    <select
                                                        v-model="
                                                            v$.classification_id.$model
                                                        "
                                                        class="form-select"
                                                        id="background_id"
                                                        name="background_id"
                                                        required
                                                    >
                                                        <option
                                                            :value="''"
                                                            selected
                                                        >
                                                            Selecciona una
                                                            opción...
                                                        </option>
                                                        <option
                                                            v-for="res in classifications"
                                                            :value="res.id"
                                                        >
                                                            {{ `${res.name}` }}
                                                        </option>
                                                    </select>
                                                    <div v-for="(error, index) in v$.classification_id.$errors" :key="index" class="invalid-feedback d-block">
                                                        {{ error.$message }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label"
                                                    for="background_id"
                                                    >CONTENEDORES</label
                                                >
                                                <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                                                    <select
                                                        v-model="
                                                            v$.container_id.$model
                                                        "
                                                        class="form-select"
                                                        id="background_id"
                                                        name="background_id"
                                                        required
                                                    >
                                                        <option
                                                            :value="''"
                                                            selected
                                                        >
                                                            Selecciona una
                                                            opción...
                                                        </option>
                                                        <option
                                                            v-for="res in containers"
                                                            :value="res.id"
                                                        >
                                                            {{ `${res.name}` }}
                                                        </option>
                                                    </select>
                                                    <div v-for="(error, index) in v$.container_id.$errors" :key="index" class="invalid-feedback d-block">
                                                        {{ error.$message }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-around">
                                                <button
                                                    class="btn btn-primary mb-2 row col-5"
                                                    type="submit"
                                                    @click.prevent="
                                                        sendDocument
                                                    "
                                                    :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0"
                                                >
                                                    CONTINUAR
                                                </button>
                                                <button
                                                    class="btn btn-light mb-2 row col-5"
                                                    @click="cancel"
                                                >
                                                    CANCELAR
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>
<script setup>
    import { toRef, ref, onMounted, watch, nextTick, reactive } from "vue";
    import VuePdfEmbed from "vue-pdf-embed";
    import { useVuelidate } from '@vuelidate/core';
    import { required, email ,minValue, helpers, minLength, maxLength} from '@vuelidate/validators';
    import useDocumentRequestsAPI from "@/api/document/index.js";
    import { useRouter, useRoute } from "vue-router";
    import $ from "jquery";
    import { Modal } from "bootstrap";

    const emit = defineEmits(['cancel', 'preparation']);

    const router = useRouter();

    const showPreparation = ref(false);
    const props = defineProps({
        classifications: Object,
        documentTypes: Object,
        containers: Object,
        dataFiles: Object
    });

    const source = ref("");
    const pdfViewer = ref(null);
    const pdfLoaded = ref(false);
    //Const to count pdf files
    const pdfIndex = ref(1);

    //Info to fill select controls
    const classifications = toRef(props, "classifications");
    const documentTypes = toRef(props, "documentTypes");
    const containers = toRef(props, "containers");
    const dataFiles = toRef(props, "dataFiles");
    const resFile = ref("");

    // const data = dataFiles.map();
    const formData = ref({
        name: "",
        container_id: "",
        classification_id: "",
        document_type_id: "",
        url: "",
    });


    //Consts to vuelidate controls
    const rules = {
        name:{
            required: helpers.withMessage('Este campo no debe estar vacio', required),
        },
        container_id: {
            required: helpers.withMessage('Debes seleccionar una opción', required),
        },
        classification_id: {
            required: helpers.withMessage('Debes seleccionar una opción', required),
        },
        document_type_id: {
            required: helpers.withMessage('Debes seleccionar una opción', required),
        },
    };
    const state = reactive(formData);
    const v$ = useVuelidate(rules, formData);

    //Life cycle
    onMounted(async () => {
    });

    //Watchs
    watch(
        () => dataFiles,
        (dataFiles, oldDataFiles) => {
            if(dataFiles !== undefined && dataFiles.value.length > 0){
                pdfLoaded.value = false;
                formData.value.name = dataFiles.value[0].path;
                getBase64(dataFiles.value[0]);
            }
        },
        { deep: true },   
    );
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
            if(source.value != ""){
                pdfLoaded.value = false;
                source.value = "";
                formData.value.name = dataFiles.value[pdfIndex.value-1].path;
                getBase64(dataFiles.value[pdfIndex.value-1]);
            }
      },
      {deep:true} 
    );

    //Methods
    function cancel(){
        formData.value = {
            name: "",
            container_id: "",
            classification_id: "",
            document_type_id: "",
            url: "",
        };
        pdfLoaded.value = false;
        source.value = "";
        pdfIndex.value = 1;
        v$._value.$reset();
        emit("cancel");
    }

    function filter () { 
        if(formData.document_type_id == 1){
            formData.url = "https://drive.google.com/uc?id=1IO2e-rsr0WKXRSF9VrwTBz92VSqthpyK&export=download"
        }
    } 

    function getBase64String(file, onLoadCallback) {
        return new Promise(function(resolve, reject) {
            var reader = new FileReader();
            reader.onload = function() { resolve(reader.result); };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    function getBase64(file) {
        let fileSource = "";
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            refreshPdf(reader.result);
        };
        reader.onerror = function (error) {
            console.log('Error: ', error);
        };
    }

    function handleDocumentRender(){
        pdfLoaded.value = true;
    }

    function refreshPdf(result){
        source.value = result;
        pdfViewer.value.$.props.source = source.value;
        refreshPdfViewer();
    }

    const refreshPdfViewer = async () => {
        await Promise.resolve(pdfViewer.value.render());
        /* await nextTick(function(){
            pdfViewer.value.render();
        }); */
    };

    function sendDocument() {
        addRequest();
    }

    const addRequest = async() => {
        let newFiles = [];
        //Method to create a file information array with all files
        for(let i = 0; i < dataFiles.value.length; i++){
            let promise = getBase64String(dataFiles.value[i]);
            let fileString = await promise;
            newFiles.push({
                name: dataFiles.value[i].path,
                data : fileString
            })
        }
        let filesInfo = {
            document_type: documentTypes.value.filter(x => x.id == formData.value.document_type_id)[0],
            classification: classifications.value.filter(x => x.id == formData.value.classification_id)[0],
            container: containers.value.filter(x => x.id == formData.value.container_id)[0],
            files : newFiles
        }
        emit('preparation', JSON.stringify(filesInfo));
        //Router push with params

        /* useDocumentRequestsAPI.addDocument(formData.value)
        .then((res) => {
            // resFile.value = res
            router.push({ path: '/mis-documentos/preparacion/' + res.id })       
        });
        // resetData(); */
    };
</script>