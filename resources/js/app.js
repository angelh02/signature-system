// require('./bootstrap');
import 'bootstrap';
import { createApp } from "vue";
import HomeComponent from "./components/Home.vue";
import router  from "./router/index.js"

const app = createApp({});

app.component('HomeComponent',HomeComponent);
app.use(router);
app.mount('#app');

