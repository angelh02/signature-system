// require('./bootstrap');
import 'bootstrap';
import 'jquery';
import { createApp } from "vue";
import HomeComponent from "./components/Home.vue";
import router  from "./router/index.js"
import ModalComponent from "./components/elements/Modal.vue"
import "vue-toastification/dist/index.css";
import Toast from "vue-toastification";

const toastOptions = {
    position: "top-right",
    timeout: 5000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
    transition: "Vue-Toastification__bounce",
  };

const app = createApp({});

// app.component('vue-pdf-app', VuePdfApp);
app.component('ModalComponent',ModalComponent)
app.component('HomeComponent',HomeComponent);
app.use(Toast, toastOptions);
app.use(router);
app.mount('#app');

