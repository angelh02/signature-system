import { ref } from "vue";

export function useFormClasificationRequest(){

    const background_id = ref("");
    const secction_id = ref("");
    const series = ref("");
    const subseriers = ref("");
    const productionArea = ref("");
    const start_period = ref("");
    const end_period = ref("");
    const consecutive_number = ref("");

    return{
        background_id,
        secction_id,
        series,
        subseriers,
        productionArea,
        start_period,
        end_period,
        consecutive_number
    };
};