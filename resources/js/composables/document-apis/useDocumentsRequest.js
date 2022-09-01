import useDocumentsRequestsAPI from "@/api/document/index.js";

export function useDocumentsRequests(from = null, to = null) {
    const getDocument= async (id) => {
        return await useDocumentsRequestsAPI.getDocument(id);
    };

    return {
        getDocument
    };
}
