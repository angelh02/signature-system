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
        },
        {
            title: "Subserie",
            data: "subseries",
        },
        {
            title: "Area de producción",
            data: "production_area.code",
        },
        {
            title: "Periodo de inicio",
            data: "start_period",
        },
        {
            title: "Fin de periodo",
            data: "end_period",
        },
        {
            title: "Consecutivo",
            data: "consecutive_number",
        },
        {
            targets: -1,
            data: null,
            className: "col-2 text-center",
            defaultContent: `<button id="btn_editar" class="btn btn-warning uil-edit-alt"></button>
                        <button id="btn_borrar" class="btn btn-danger mdi mdi-delete-forever"></button>`,
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
