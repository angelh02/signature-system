import useFileClasificationRequestsAPI from "@/api/index.js";

export function useClasificationsRequests(from = null, to = null) {
    const getBackground = async () => {
        return await useFileClasificationRequestsAPI.getBackground();
    };

    const getSection = async () => {
        return await useFileClasificationRequestsAPI.getSection();
    };

    const getProductionArea = async () => {
        return await useFileClasificationRequestsAPI.getProductionArea();
    };

    return {
        getBackground,
        getSection,
        getProductionArea,
    };
}
