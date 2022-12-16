import useContainersRequestsAPI from "@/api/container/index.js";
import Buttons from "../../components/elements/Buttons.vue";

export function useContainersRequests(from = null, to = null) {
    const containerColumns = [
        {
            title: "Id",
            data: "id",
            visible: false
        },
        {
            title: "Nombre",
            data: "name",
        },
        {
            title: "Tiempo de conservación",
            data: "conservation_time",
        },
        {
            title: "Tipo de conservación",
            data: "conservation_type",
        },
        {
            title: "Valor documental",
            data: "document_value",
        },
        {
            title: "Tipo de información",
            data: "information_type",
        },
        {
            title: "Técnica de selección",
            data: "selection_technique",
        },
        {
            title: "Fecha efectiva",
            data: "effective_date",
            visible: false
        },
        {
            targets: -1,
            data: null,
            className: "col-2 text-center",
            defaultContent: `<button id="btn_editar" class="btn btn-warning uil-edit-alt"></button>`,
        },
    ];

    const getContainers = async () => {
        return await useContainersRequestsAPI.getContainers();
    };

    return {
        containerColumns,
        getContainers,
    };
}
