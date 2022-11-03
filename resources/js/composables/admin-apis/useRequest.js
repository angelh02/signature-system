
export function useRequests(from = null, to = null) {
    const RequestColumns = [
        {
            title: "Folio",
            data: "id",
            visible: true
        },
        {
            title: "Asunto",
            data: "subject",
        },
        {
            title: "Documento",
            data: "document.name",
        },
        {
            title: "Usuario",
            data: "document.user.name",
        },
        {
            title: "Estatus",
            data: "status",
        },
        {
            targets: -1,
            data: null,
            className: "col-2 text-center",
            defaultContent: `<button id="btn_editar" class="btn btn-success mdi mdi-check-outline"></button>
                        <button id="btn_borrar" class="btn btn-danger mdi mdi-cancel"></button>
                        <button id="btn_detalles" class="btn btn-info mdi mdi-eye"></button>`,
        },
    ];
    return {
        RequestColumns,
    };
}