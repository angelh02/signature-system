// require('./bootstrap');
import 'bootstrap';
import 'jquery';
import { createApp } from "vue";
import HomeComponent from "./components/Home.vue";
import router  from "./router/index.js"
import ModalComponent from "./components/elements/Modal.vue"

const app = createApp({});

// app.component('vue-pdf-app', VuePdfApp);
app.component('ModalComponent',ModalComponent)
app.component('HomeComponent',HomeComponent);
app.use(router);
app.mount('#app');

