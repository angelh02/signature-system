import {createRouter, createWebHistory} from "vue-router"
const Home = () => import("../components/mydocuments/DocumentsPreparation.vue")
const Documents = () => import("../components/mydocuments/Documents.vue")
const FileClasification = () => import("../components/fileclasification/FileClasification.vue")
const Containers = () => import("../components/containers/Containers.vue")
const DocumentsPreparation = () => import("../components/mydocuments/DocumentsPreparation.vue")
const DocumentStatus = () => import("../components/mydocuments/DocumentStatus.vue");
const DocumentSign = () => import("../components/document-sign/DocumentSign.vue");


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
        path: '/documents/preparation/:datafile',
        name: 'DocumentsPreparation',
        component: DocumentsPreparation
    },
    {
        path: '/fileclasification',
        name: 'FileClasification',
        component: FileClasification
    },
    {
        path: '/containers',
        name: 'Containers',
        component: Containers
    },
    {
        path: '/document/status/:id',
        name: 'DocumentStatus',
        component: DocumentStatus
    },
    {
        path: '/document/sign/:id',
        name: 'DocumentSign',
        component: DocumentSign
    }

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router

