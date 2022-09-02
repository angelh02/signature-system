import useDocumentsRequestsAPI from "@/api/document/index.js";
import useClasificationRequestsAPI from "@/api/index.js";
import useContainerRequestsAPI from "@/api/container/index.js";



export function useDocumentsRequests(from = null, to = null) {
    const getDocument= async (id) => {
        return await useDocumentsRequestsAPI.getDocument(id);
    };

    const getDocumentsType = async () => {
        return await useDocumentsRequestsAPI.getDocumentsType();
    };

    const getClasification = async () => {
        return await useClasificationRequestsAPI.getClasification();
    };

    const getContainers = async () => {
        return await useContainerRequestsAPI.getContainers();
    };


    return {
        getDocument,
        getDocumentsType,
        getClasification,
        getContainers
    };
}
