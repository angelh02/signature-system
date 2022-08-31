import useContainersRequestsAPI from "@/api/container/index.js";
import Buttons from "../../components/elements/Buttons.vue";

export function useContainersRequests(from = null, to = null) {
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
            title: "TC",
            data: "conservation_time.code",
        },
        {
            title: "TC",
            data: "conservation_type.code",
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
        },
        {
            targets: -1,
            data: null,
            className: "col-2 text-center",
            defaultContent: `<button id="btn_editar" class="btn btn-warning uil-edit-alt"></button>
                        <button id="btn_borrar" class="btn btn-danger mdi mdi-delete-forever"></button>`,
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
