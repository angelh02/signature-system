import useFileClasificationRequestsAPI from "@/api/index.js";
import Buttons from "../components/elements/Buttons.vue"


export function useFileClasificationRequests(from = null, to = null) {

const filesColumns = [
    {
      title: 'Name',
      data: 'name'
    },
    {
      title: 'Url',
      data: 'url'
    }, 
    {
        targets: -1,
        data: null,
        defaultContent:  `<button id="btn_editar" class="btn btn-warning uil-edit-alt"></button>
                        <button id="btn_borrar" class="btn btn-danger mdi mdi-delete-forever"></button>`,
    },
  ];

  const getFileRequests = async () => {
    return await useFileClasificationRequestsAPI.getFileRequests();
  };

  return {
    filesColumns,
    getFileRequests,
  };
}
