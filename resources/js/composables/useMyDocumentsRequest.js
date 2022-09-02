import useDocumentsRequestsAPI from "@/api/index.js";

export function useDocumentsRequest(from = null, to = null) {

    const filesColumns = [
        {
            title: "Id",
            data: "id",
            visible: false
        },
        {
            title: "Nombre de documento",
            data: "name",
        },
        {
            title: "Participantes",
            data: "participantes",
        },
        {
            title: "Creado",
            data: "create",
        },
        {
            title: "Firmado",
            data: "firmado",
        },
        {
            title: "Clasificación",
            data: "clasification",
        },
        {
            title: "Periodo de inicio",
            data: "start_end",
        },
        {
            targets: -1,
            data: null,
            className: "col-2 text-center",
            defaultContent: `<div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown link
                </a>
                
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>`,
        },
    ];

    const getClasification = async () => {
        return await useFileClasificationRequestsAPI.getClasification();
    };

    return {
        filesColumns,
        getClasification,
    };
}
