import useDocumentsRequestsAPI from "@/api/documents/index.js";
import Buttons from "../../components/elements/Buttons.vue";

export function useDocumentsRequests(from = null, to = null) {
    const containerColumns = [
        {
            title: "Id",
            data: "id",
            visible: true
        },
        {
            title: "Nombre",
            data: "name",
        },
        {
            title: "Tipo Documento",
            data: "document_type.name",
        },
        {
            title: "Clasificación",
            data: "classification.name",
        },
        {
            title: "Contenedor",
            data: "container.name",
        },
        {
            title: "VD",
            data: "document_value.code",
        },
        {
            title: "IT",
            data: "information_type.code",
        },
        {
            title: "ST",
            data: "selection_technique.code",
        }
    ];

    const getDocuments = async () => {
        return await useDocumentsRequestsAPI.getDocuments();
    };

    return {
        containerColumns,
        getDocuments,
    };
}
