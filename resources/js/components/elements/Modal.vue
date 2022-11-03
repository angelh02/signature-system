<script setup>
import { toRef, ref, onMounted } from "vue";
import VuePdfEmbed from "vue-pdf-embed";
import useDocumentRequestsAPI from "@/api/document/index.js";
import { useRouter, useRoute } from "vue-router";


const emit = defineEmits(["showPreparation", "close", "resFile"]);
const router = useRouter();

const source = ref("");

const clasifications = toRef(props, "clasifications");
const typesDocument = toRef(props, "typesDocument");
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

function filter () { 
    if(formData.document_type_id == 1){
        formData.url = "https://drive.google.com/uc?id=1IO2e-rsr0WKXRSF9VrwTBz92VSqthpyK&export=download"
    }
} 


const showPreparation = ref(false);
const props = defineProps({
    show: Boolean,
    clasifications: Object,
    typesDocument: Object,
    containers: Object,
    dataFile: Object
});


function sendDocument() {
    /* showPreparation.value = true;
    emit("showPreparation", showPreparation.value);
    emit("close"); */
    addRequest();
}

onMounted(async () => {
    formData.value.name = dataFile;
    let index = documentsFiles.value.findIndex(x => x.name == formData.value.name);
    source.value = "/pdf/"+(index == -1? documentsFiles.value[0].name : documentsFiles.value[index].name);
    formData.value.url = index == -1? documentsFiles.value[0].url : documentsFiles.value[index].url;
});

const addRequest = (async) => {
    useDocumentRequestsAPI.addDocument(formData.value)
    .then((res) => {
        // resFile.value = res
        router.push({ path: '/mis-documentos/preparacion/' + res.id })       
    });
    // resetData();
};
</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="modal-mask">
            <div class="card col-11 container-fluid my-4">
                <div class="">
                    <div class="modal-content">
                        <!-- <div class="modal-header">
                            <button
                                type="button"
                                class="btn-close"
                                @click="$emit('close')"
                            ></button>
                        </div> -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <VuePdfEmbed
                                        v-if="source != ''"
                                        :source="source"
                                        class="scrollspy-example"
                                    ></VuePdfEmbed>
                                </div>
                                <div
                                    class="col-4 row mx-0 justify-content-center"
                                >
                                    <div class="">
                                        <div class="card-header">
                                            <h2>Preparación del documento</h2>
                                        </div>
                                        <div class="border-start">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="validationCustom06"
                                                        >NOMBRE DEL
                                                        DOCUMENTO</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        placeholder="Ingrese Nombre"
                                                        maxlength="30"
                                                        v-model="formData.name"
                                                        required
                                                    />
                                                    <div
                                                        v-if="submit"
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
                                                            v-for="res in typesDocument"
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
                                                            v-for="res in clasifications"
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
                                                        type="submit"
                                                        @click="$emit('close')"
                                                    >
                                                        CANCELAR
                                                    </button>
                                                </div>
                                                {{ dataFile[0].path }}
                                                {{ dataFile[0].type }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card-footer">
                            <button
                                type="button"
                                class="btn btn-light"
                                @click="$emit('close')"
                            >
                                Close
                            </button>
                            <button type="button" class="btn btn-primary">
                                Save changes
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </Transition>
    <div
        id="standard-modal"
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="standard-modalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">
                        Modal Heading
                    </h4>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-hidden="true"
                    ></button>
                </div>
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</template>

<style>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}

.scrollspy-example {
    height: 838px;
}
</style>
