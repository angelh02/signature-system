const Request = () => import("../components/admin/request/Request.vue");
const UserAdmin = () => import("../components/admin/user-admin/UserAdmin.vue");
const Catalogs = () => import("../components/admin/catalogs/GlobalCatalogs.vue");

const adminRoutes = [
    {
        path: '/solicitudes',
        name: 'Request',
        component: Request
    },
    {
        path: '/usuarios',
        name: 'UserAdmin',
        component: UserAdmin
    },
    {
        path: '/catalogo/:name',
        name: 'Catalogs',
        component: Catalogs
    }

]

export {adminRoutes}

