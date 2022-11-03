export function useAdminUser(from = null, to = null) {
    const userColumns = [
        {
            title: "Folio",
            data: "id",
            visible: true
        },
        {
            title: "Nombre",
            data: "name",
        },
        {
            title: "Apellido",
            data: "surnames",
        },
        {
            title: "Nombre de Usuario",
            data: "user_name",
        },
        {
            title: "Email",
            data: "email",
        },
        {
            title: "Estado",
            data: "active",
        },
        {
            title: "Rol",
            data: "roles[0].name",
        },
        {
            targets: -1,
            data: null,
            className: "col-2 text-center",
            defaultContent: `<button id="btn_editar" class="btn btn-warning uil-edit-alt"></button>
                        <button id="btn_reset" class="btn btn-success mdi mdi-restart"></button>`,
        },
    ];
    return {
        userColumns,
    };
}