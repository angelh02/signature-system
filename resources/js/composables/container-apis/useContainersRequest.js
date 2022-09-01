import useContainersRequestsAPI from "@/api/container/index.js";

export function useContainersRequests(from = null, to = null) {
    const getConservationTimes = async () => {
        return await useContainersRequestsAPI.getConservationTimes();
    };

    const getConservationTypes = async () => {
        return await useContainersRequestsAPI.getConservationTypes();
    };

    const getDocumentValues = async () => {
        return await useContainersRequestsAPI.getDocumentValues();
    };

    const getInformationTypes = async () => {
        return await useContainersRequestsAPI.getInformationTypes();
    };

    const getSelectionTechniques = async () => {
        return await useContainersRequestsAPI.getSelectionTechniques();
    };

    return {
        getConservationTimes,
        getConservationTypes,
        getDocumentValues,
        getInformationTypes,
        getSelectionTechniques
    };
}
