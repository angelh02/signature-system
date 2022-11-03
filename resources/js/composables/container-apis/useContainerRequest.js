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
            title: "TC",
            data: "conservation_time.name",
        },
        {
            title: "TC",
            data: "conservation_type.name",
        },
        {
            title: "VD",
            data: "document_value.name",
        },
        {
            title: "IT",
            data: "information_type.name",
        },
        {
            title: "ST",
            data: "selection_technique.name",
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
