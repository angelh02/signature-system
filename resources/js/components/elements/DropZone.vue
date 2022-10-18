<template>
    <div
        @dragenter.prevent="toggleActive"
        @dragleave.prevent="toggleActive"
        @dragover.prevent
        @drop.prevent="toggleActive"
        :class="{ 'active-dropzone': active }"
        class="dropzone"
    >
        <!-- <input type="file" id="dropzoneFile" class="dropzoneFile btn-check" /> -->

        <div class="dz-message needsclick row align-items-center">
            <div class="row">
                    <h4 class="h3 text-muted mdi mdi-file-upload-outline" for="dropzoneFile">
                        Arrastra tu documeto a la página o
                        <!-- <a type="file" id="dropzoneFile" class="dropzoneFile">da click aquí para seleccionar uno</a> -->
                        <label for="dropzoneFile"
                            ><a class="text-info"
                                >click aquí para seleccionar uno</a
                            ></label
                        >
                        <input
                            type="file"
                            id="dropzoneFile"
                            class="dropzoneFile btn-check"
                            accept="application/pdf"
                        />
                    </h4>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
export default {
    name: "DropZone",
    setup() {
        const active = ref(false);
        const toggleActive = () => {
            active.value = !active.value;
        };
        return { active, toggleActive };
    },
};
</script>

<style scoped lang="scss">
.active-dropzone {
    color: #fff;
    border-color: #fff;
    background-color: #0c8ce9;
}
</style>
