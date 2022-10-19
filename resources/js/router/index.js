import {createRouter, createWebHistory} from "vue-router"
import { adminRoutes } from "./admin"
const Home = () => import("../components/mydocuments/Documents.vue")
const Documents = () => import("../components/mydocuments/Documents.vue")
const FileClasification = () => import("../components/fileclasification/FileClasification.vue")
const Containers = () => import("../components/containers/Containers.vue")
const DocumentsPreparation = () => import("../components/mydocuments/DocumentsPreparation.vue")
const DocumentDetails = () => import("../components/mydocuments/DocumentDetails.vue")
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
        path: '/mis-documentos/detalles/:id',
        name: 'DocumentsDetails',
        props:true,
        component: DocumentDetails
    },
    {
        path: '/mis-documentos/estado/:id',
        name: 'DocumentStatus',
        component: DocumentStatus
    },
    {
        path: '/mis-documentos/preparacion',
        name: 'DocumentsPreparation',
        component: DocumentsPreparation,
        props: (route) => {
            route.params
        }
    },
    {
        path: '/clasificaciones-archivisticas',
        name: 'FileClasification',
        component: FileClasification
    },
    {
        path: '/contenedores',
        name: 'Containers',
        component: Containers
    },
    {
        path: '/documento/firmar/:id',
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

