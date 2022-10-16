<template>
    <div>
        <div id="create-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-full-width">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="d-flex align-items-center" v-if="!pdfLoaded">
                                    <strong>Loading...</strong>
                                    <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
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
                                                <input
                                                    ref="nameInput"
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    placeholder="Ingrese Nombre"
                                                    maxlength="30"
                                                    v-model="formData.name"
                                                    required
                                                />
                                                <div
                                                    v-if=""
                                                    class="mensajeError"
                                                >
                                                    Debe ingresar un nombre
                                                </div>
                                                <div
                                                    class="invalid-feedback"
                                                >
                                                    Please provide a valid
                                                    zip.
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label"
                                                    for="background_id"
                                                    >TIPO DE
                                                    DOCUMENTO</label
                                                >
                                                <select
                                                    v-model="
                                                        formData.document_type_id
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
                                                <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label"
                                                    for="background_id"
                                                    >CLASIFICACIÓN</label
                                                >
                                                <select
                                                    v-model="
                                                        formData.classification_id
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
                                                <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label"
                                                    for="background_id"
                                                    >CONTENEDORES</label
                                                >
                                                <select
                                                    v-model="
                                                        formData.container_id
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
                                                <!-- <div class="mensajeError">Debe escoger una opcion</div> -->
                                            </div>
                                            <div class="d-flex justify-content-around">
                                                <button
                                                    class="btn btn-primary mb-2 row col-5"
                                                    type="submit"
                                                    @click.prevent="
                                                        sendDocument
                                                    "
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
                                            {{ dataFile[0]?.path }}
                                            {{ dataFile[0]?.type }}
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
    import { toRef, ref, onMounted, watch, nextTick } from "vue";
    import VuePdfEmbed from "vue-pdf-embed";
    import useDocumentRequestsAPI from "@/api/document/index.js";
    import { useRouter, useRoute } from "vue-router";
    import $ from "jquery";
    import { Modal } from "bootstrap";

    const emit = defineEmits(['cancel']);

    const router = useRouter();

    const showPreparation = ref(false);
    const props = defineProps({
        classifications: Object,
        documentTypes: Object,
        containers: Object,
        dataFile: Object
    });

    const source = ref("");
    const pdfViewer = ref(null);
    const pdfLoaded = ref(false);

    const classifications = toRef(props, "classifications");
    const documentTypes = toRef(props, "documentTypes");
    const containers = toRef(props, "containers");
    const dataFile = toRef(props, "dataFile");
    const resFile = ref("");
    const url = ref(dataFile)

    const documentsFiles = ref([
        {
            name:"minuta_reunion.pdf",
            url:"https://drive.google.com/uc?id=1e4Pg3SkXZh6NEldfTNTUmzTGxE3VQlvd&export=download",
        },
        {
            name:"lista_asistencia.pdf",
            url:"https://drive.google.com/uc?id=1sJ1hGDWhFW-3etoSo5gnUAatUxiImXrj&export=download",
        },
        {
            name:"constancia_servicio_social.pdf",
            url:"https://drive.google.com/uc?id=1QvAC2oJqRnUHddwkJiUOkxIQJ5jyb5ln&export=download",
        },
        {
            name:"carta_no_adeudo.pdf",
            url:"https://drive.google.com/uc?id=1IO2e-rsr0WKXRSF9VrwTBz92VSqthpyK&export=download",
        },
        {
            name:"acta_calificaciones.pdf",
            url:"https://drive.google.com/uc?id=1tEg_1Kt6N97-waTcHtmIVsR2Tm_ztOl7&export=download",
        },
    ])

    // const data = dataFile.map();
    const formData = ref({
        name: "",
        container_id: "",
        classification_id: "",
        document_type_id: "",
        url: "",
    });
    //Life cycle
    onMounted(async () => {
    });

    //Watchs
    watch(
        () => dataFile,
        (dataFile, oldDataFile) => {
            console.log(dataFile.value);
            if(/* dataFile[0] !== undefined && dataFile[0].path !== undefined */dataFile !== undefined && dataFile.value.length > 0){
                /* source.value = ""; */
                pdfLoaded.value = false;
                formData.value.name = dataFile.value[0].path;
                let index = documentsFiles.value.findIndex(x => x.name == formData.value.name);
                formData.value.url = index == -1? documentsFiles.value[0].url : documentsFiles.value[index].url;
                getBase64(dataFile.value[0]);
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
    )

    //Methods
    function cancel(){
        pdfLoaded.value = false;
        source.value = "";
        emit("cancel");
    }
    function filter () { 
        if(formData.document_type_id == 1){
            formData.url = "https://drive.google.com/uc?id=1IO2e-rsr0WKXRSF9VrwTBz92VSqthpyK&export=download"
        }
    } 

    function getBase64(file) {
        let fileSource = "";
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            refreshPdf(reader.result);
            //console.log("🚀 ~ file: CreateDocumentModal.vue ~ line 271 ~ getBase64 ~ reader.result", reader.result)
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
        /* showPreparation.value = true;
        emit("showPreparation", showPreparation.value);
        emit("close"); */
        addRequest();
        console.log(index);
    }

    const addRequest = (async) => {
        console.log(documentTypes.value[0].id)
        useDocumentRequestsAPI.addDocument(formData.value)
        .then((res) => {
            // resFile.value = res
            router.push({ path: '/mis-documentos/preparacion/' + res.id })       
        });
        // resetData();
    };
</script>