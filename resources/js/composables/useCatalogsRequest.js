import useFileClasificationRequestsAPI from "@/api/index.js";
import useFileCatalogsBackgroundAPI from "@/api/admin/catalogs/classification/background.js";
import useFileCatalogsProductionAPI from "@/api/admin/catalogs/classification/production-area.js";
import useFileCatalogsSectionAPI from "@/api/admin/catalogs/classification/section.js";

export function useCatalogsRequests(from = null, to = null) {
    const getBackground = async () => {
        return await useFileCatalogsBackgroundAPI.getAll();
    };

    const getSection = async () => {
        return await useFileCatalogsProductionAPI.getAll();
    };

    const getProductionArea = async () => {
        return await useFileCatalogsSectionAPI.getAll();
    };

    return {
        getBackground,
        getSection,
        getProductionArea,
    };
}
