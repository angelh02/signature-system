import {createRouter, createWebHistory} from "vue-router"
const Home = () => import("../components/Home.vue")
const Documents = () => import("../components/mydocuments/Documents.vue")
const FileClasification = () => import("../components/fileclasification/FileClasification.vue")
// import Home from './components/Home.vue';
// import Documents from './components/Documents.vue';
// import FileClasification from './components/FileClasification.vue';

const routes = [
    {
        path: '/home',
        name: 'Home',
        component: Home
    },
    {
        path: '/documents',
        name: 'Documents',
        component: Documents
    },
    {
        path: '/fileclasification',
        name: 'FileClasification',
        component: FileClasification
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router

