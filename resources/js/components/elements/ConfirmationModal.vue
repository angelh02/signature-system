<template>
    <div>
        <div :id="modalId != null && modalId != ''? modalId : 'confirmation-modal'" class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title" id="primary-header-modalLabel">{{title}}</h4>
                        <button type="button" class="btn-close btn-close-white" @click="response(false)"></button>
                    </div>
                    <div class="modal-body">
                        {{message}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" @click="response(false)">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="response(true)">Aceptar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>
<script setup>
    import { ref, toRef} from 'vue';

    const emit = defineEmits(['response']);

    const props = defineProps({
        title: String,
        message: String,
        modalId: String
    });

    const title = toRef(props, 'title');
    const message = toRef(props, 'message');
    const modalId = toRef(props, 'modalId');

    function response(value){
        emit('response', value);
    }
</script>