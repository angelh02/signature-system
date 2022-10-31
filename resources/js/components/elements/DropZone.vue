<template>
    <div class="dropzone" v-bind="getRootProps()">
        <div class="dz-message needsclick row align-items-center">
            <input id="key-file" v-bind="getInputProps()" :accept="acceptedFiles"/>
            <h4 class="text-muted mdi mdi-file-upload-outline">
                {{title}}
                <label
                    ><a type="button" class="text-primary"
                        >click aquí para seleccionar uno</a
                    ></label
                >
                <input
                    class="dropzoneFile btn-check"
                />
            </h4>
        </div>
    </div>
</template>
<script setup>
    import { ref, onMounted, watch, toRefs, toRef, reactive, useAttrs } from "vue";
    import { useDropzone } from "vue3-dropzone";

    const emit = defineEmits(['onDrop']);

    const props = defineProps({
        title : String,
        acceptedFiles : String
    });
    const title = toRef(props, 'title');
    const acceptedFiles = toRef(props, 'acceptedFiles');

    const { getRootProps, getInputProps, ...restCer } = useDropzone({ onDropAccepted });

    //Functions to dropzone
    function onDropAccepted(acceptFiles) {
        emit('onDrop', acceptFiles)
    }
</script>
