import { ref } from "vue";

export function useFormContainerRequest(){

    const name = ref("");
    const document_value_id = ref(0);
    const conservation_time_id = ref(0);
    const selection_technique_id = ref(0);
    const conservation_type_id = ref(0);
    const information_type_id = ref(0);
    const effective_date = ref("");

    return{
        name,
        document_value_id,
        conservation_time_id,
        selection_technique_id,
        conservation_type_id,
        information_type_id,
        effective_date
    };
};