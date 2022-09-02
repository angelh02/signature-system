import useDocumentsRequestsAPI from "@/api/document/index.js";


export function useDocumentsRequests(from = null, to = null) {
    const containerColumns = [
        /* {
            title: "Id",
            data: "id",
            visible: true
        }, */
        {
            title: "Nombre",
            /* data: "name", */
        },
        {
            title: "Tipo Documento",
            /* data: "document_type.name", */
        },
        {
            title: "Clasificación",
            /* data: "classification.name", */
        },
        {
            title: "Contenedor",
           /*  data: "container.name", */
        },
        {
            targets: -1,
            /* data: null,
            className: "col-2 text-center",
            defaultContent: `
                            <div>
                                <div class="dropdown">
                                    <a v-if="container != null" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Descargar
                                    </a>                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <div>
                                        <h5 class="dropdown-header col-2">Por cada documento generado 
                                        se generan 2 archivos:<br>
                                        uno XML y uno PDf asegurate<br> 
                                        de descargar ambos</h5>
                                        </div>
                                        <a class="dropdown-item" href="#">Descaragar pdf y xml</a>
                                        <a class="dropdown-item" href="#">Descaragar pdf</a>
                                        <a class="dropdown-item" href="#">Descaragar xml</a>
                                    </div>
                                </div>
                            </div>
                            `, */
        },
    ];

    const getDocuments = async () => {
        return await useDocumentsRequestsAPI.getDocuments();
    };

    return {
        containerColumns,
        getDocuments,
    };
}
