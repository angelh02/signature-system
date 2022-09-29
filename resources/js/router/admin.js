const Request = () => import("../components/admin/request/Request.vue");
const UserAdmin = () => import("../components/admin/user-admin/UserAdmin.vue");
const Catalogs = () => import("../components/admin/catalogs/GlobalCatalogs.vue");

const adminRoutes = [
    {
        path: '/request',
        name: 'Request',
        component: Request
    },
    {
        path: '/user-admin',
        name: 'UserAdmin',
        component: UserAdmin
    },
    {
        path: '/catalogs',
        name: 'Catalogs',
        component: Catalogs
    }

]

export {adminRoutes}

