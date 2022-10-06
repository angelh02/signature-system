import {createRouter, createWebHistory} from "vue-router"
import { adminRoutes } from "./admin"
const Home = () => import("../components/mydocuments/Documents.vue")
const Documents = () => import("../components/mydocuments/Documents.vue")
const FileClasification = () => import("../components/fileclasification/FileClasification.vue")
const Containers = () => import("../components/containers/Containers.vue")
const DocumentsPreparation = () => import("../components/mydocuments/DocumentsPreparation.vue")
const DocumentStatus = () => import("../components/mydocuments/DocumentStatus.vue");
const DocumentSign = () => import("../components/document-sign/DocumentSign.vue");
const Request = () => import("../components/admin/request/Request.vue");
const UserAdmin = () => import("../components/admin/user-admin/UserAdmin.vue");
const Catalogs = () => import("../components/admin/catalogs/GlobalCatalogs.vue");



// import Home from './components/Home.vue';
// import Documents from './components/Documents.vue';
// import FileClasification from './components/FileClasification.vue';

const routes = [
    ...adminRoutes,
    {
        path: '/mis-documentos',
        name: 'Documents',
        component: Documents
    },
    {
        path: '/mis-documentos/preparacion/:id',
        name: 'DocumentsPreparation',
        props:true,
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
    },
    // {
    //     path: '/request',
    //     name: 'Request',
    //     component: Request
    // },
    // {
    //     path: '/user-admin',
    //     name: 'UserAdmin',
    //     component: UserAdmin
    // },
    // {
    //     path: '/catalogs',
    //     name: 'Catalogs',
    //     component: Catalogs
    // }

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router

