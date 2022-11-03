
export function useCatalogsRequests(from = null, to = null) {
    const catalogsColumns = [
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
            title: "Código",
            data: "code",
        },
        {
            targets: -1,
            data: null,
            className: "col-2 text-center",
            defaultContent: `<button id="btn_editar" class="btn btn-warning uil-edit-alt" data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="Editar" ></button>`,
        },
    ];
    return {
        catalogsColumns,
    };
}