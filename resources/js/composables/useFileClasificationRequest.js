import useFileClasificationRequestsAPI from "@/api/index.js";
import Buttons from "../components/elements/Buttons.vue";

export function useFileClasificationRequests(from = null, to = null) {
    const filesColumns = [
        {
            title: "Id",
            data: "id",
            visible: false
        },
        {
            title: "Clasificación",
            data: "name",
        },
        {
            title: "Fondo",
            data: "background.code",
        },
        {
            title: "Sección",
            data: "section.code",
        },
        {
            title: "Series",
            data: "series",
            visible: false
        },
        {
            title: "Subserie",
            data: "subseries",
            visible: false
        },
        {
            title: "Area de producción",
            data: "production_area.code",
        },
        {
            title: "Periodo de inicio",
            data: "start_period",
            visible: false
        },
        {
            title: "Fin de periodo",
            data: "end_period",
            visible: false
        },
        {
            title: "Consecutivo",
            data: "consecutive_number",
            visible: false
        },
        {
            targets: -1,
            data: null,
            className: "col-2 text-center",
            defaultContent: `<button id="btn_editar" class="btn btn-warning uil-edit-alt"></button>`,
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
