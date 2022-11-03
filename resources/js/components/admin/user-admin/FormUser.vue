<template>
    <div class="card-title">
        <h4 v-if="!edit">Agregar nuevo usuario</h4>
        <h4 v-if="edit">Editar usuario</h4>
    </div>
    <form class="needs-validation" @submit.prevent="onSubmit" novalidate>
        <div class="mb-3">
            <label class="form-label"
                >Nombre</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Ingrese"
                    minlength="4"
                    maxlength="20"
                    v-model="v$.name.$model"
                    required
                />
                <div v-for="(error, index) in v$.name.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >Apellido</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="text"
                    class="form-control"
                    id="surname"
                    placeholder="Ingrese"
                    minlength="4"
                    maxlength="20"
                    v-model="v$.surnames.$model"
                    required
                />
                <div v-for="(error, index) in v$.surnames.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >Nombre de usuario</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="text"
                    class="form-control"
                    id="user_name"
                    placeholder="Ingrese"
                    minlength="1"
                    maxlength="10"
                    v-model="v$.user_name.$model"
                    required
                />
                <div v-for="(error, index) in v$.user_name.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >RFC</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="text"
                    class="form-control"
                    id="RFC"
                    placeholder="Ingrese"
                    minlength="13"
                    maxlength="13"
                    v-model="v$.RFC.$model"
                    required
                />
                <div v-for="(error, index) in v$.RFC.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"
                >Email</label
            >
            <div :class="{ valid: !v$.$error && v$.$dirty, error: v$.$error }">
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="Ingrese"
                    minlength="5"
                    maxlength="255"
                    v-model="v$.email.$model"
                    required
                />
                <div v-for="(error, index) in v$.email.$errors" :key="index" class="invalid-feedback d-block">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="mb-3 ">
            <label class="form-label"
                >Activo</label
            >
            <div class="" >
                <input v-model="formData.active" class="form-control" type="checkbox" id="switch3" data-switch="success"/>
                <label for="switch3" data-on-label="Si" data-off-label="No"></label>
            </div>
            
        </div>

        <div class="mb-3 ">
            <label class="form-label" for="selection_technique_id">Roles</label>
            <select
                class="form-select"
                id="role_id"
                name="selectionTechnique"
                v-model="formData.role_id"
                required
            >
                <option :value="0" disabled selected>Selecciona una opción...</option>
                <option v-for="res in roles" :value="res.id">
                    {{ `${res.id}` }} - {{ `${res.name}` }}
                </option>
            </select>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="row justify-items-center">
            <button v-if="!edit" class="btn btn-primary mb-2" type="submit" @click.prevent="addUser" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">
                AGREGAR USUARIO
            </button>
            <button v-if="edit" class="btn btn-primary mb-2" type="submit" @click.prevent="editUser" :disabled="v$.$errors.length > 0 || v$.$silentErrors.length > 0">
                ACTUALIZAR USUARIO
            </button>
            <button class="btn btn-light mb-2" type="submit" @click="resetData()">CANCELAR</button>
        </div>
    </form>
</template>

<script setup>
import { ref, toRef, onMounted, reactive} from 'vue';
import { useRouter, useRoute } from "vue-router";
import $ from "jquery";
import { useVuelidate } from '@vuelidate/core'
import { required, email ,minValue, helpers, minLength, maxLength} from '@vuelidate/validators'

// Roles
import useFileUserAPI from "@/api/admin/user/index.js";
import {useToast} from "vue-toastification";

const toast = useToast();
const router = useRouter();
const route = useRoute();
const emit = defineEmits(['update','cancel'])

const props = defineProps({
    dataForm: Object,
    edit: Boolean,
    param: String
});

//ReadOnly
const dataForm = toRef(props, 'dataForm');
const edit = toRef(props, 'edit');
const roles = ref("");

const formData = reactive(dataForm);

const showAll = ref(false);
    const rules = {
       
      name: {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        minLength: helpers.withMessage('Minimo debe ser 4 caracteres', minLength(4)),
        maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
      }, 
      surnames: {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        minLength: helpers.withMessage('Minimo debe ser 4 caracteres', minLength(4)),
        maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
      },
      user_name:  {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        minLength: helpers.withMessage('Minimo debe ser 5 caracteres', minLength(5)),
        maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
      },
     
        email: {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        minLength: helpers.withMessage('Minimo debe ser 5 caracteres', minLength(5)),
        maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
        email: helpers.withMessage('Debe ser un email valido', email)
      },
    //     active:{
    //     required: helpers.withMessage('Este campo no debe estar vacio', required),
    //     minLength: helpers.withMessage('Minimo debe ser 5 caracteres', minLength(5)),
    //     maxLength: helpers.withMessage('Maximo debe ser 255 caracteres', maxLength(255)),
    //   },
        role_id:{
        required: helpers.withMessage('Este campo no debe estar vacio', required)
      },
      RFC:  {
        required: helpers.withMessage('Este campo no debe estar vacio', required),
        minLength: helpers.withMessage('Minimo debe ser 13 caracteres', minLength(13)),
        maxLength: helpers.withMessage('Maximo debe ser 13 caracteres', maxLength(13)),
      },
    };
    const state = reactive(dataForm);

const v$ = useVuelidate(rules, formData);
 
const onSubmit = async (values) => {
    // if(v$.$invalid){
    //     console.log("Es invalido");
    //     return
        
    // }
   
};

onMounted(async () => {
    await getRequests();
});

const addUser = async () => {
    onSubmit();
    let data = formData.value;
    data.active = data.active ? 1 : 0;
    useFileUserAPI.store(data)
    .then((res) => {
        toast.success("Se ha agregado corectamente", {
          timeout: 2000,
        });
    })
    .catch(error => 
        toast.warning("No se ha podido agregar, verifique que los datos sean correctos", {
          timeout: 2000,
        })
    );
    emit('update');
    resetData();
    onSubmit();
};

const editUser = async => {
    onSubmit()
    let data = formData.value;
    data.active = data.active ? 1 : 0;
    useFileUserAPI.update(data)
    .then((res) => {
        toast.success("El registro se ha actualizado corectamente", {
          timeout: 2000,
        })
    })
    .catch((error) =>{
        toast.error("El registro no se ha podido actualizar", {
          timeout: 2000,
        });
    });
    emit('update');
    resetData();
}

function resetData(){
    v$._value.$reset();
    emit('cancel');
}


const getRequests = async () => {
    const resRoles =  await useFileUserAPI.getRoles("");
    roles.value = resRoles; 
};


</script>