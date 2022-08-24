<template>
   <table id="example" class="table table-striped cell-border" style="width:100%">
    </table>
</template>

<script setup>
import {ref,onMounted} from 'vue';
import $ from 'jquery';
import {dataTable,table,row} from 'datatables';
import {useFileClasificationRequests} from "@/js/composables/useFileClasificationRequest.js"

const filesClasification = ref("");
const name = ref("");
const fila = ref("")

const {
    filesColumns,
    getFileRequests,
} = useFileClasificationRequests();

onMounted(async () => {
      await getRequests()
       $('#example').dataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        data:filesClasification.value.results,
        columns:filesColumns,
        scrollY: '50vh',
        scrollCollapse: true,
        // paginate: true,
        // scrollY: 300
    });
    $('#example tbody').on('click', '#btn_editar', function () {
        fila.value = $(this).closest("tr");	           
        name.value = fila.value.find('td:eq(0)').text();
        console.log(name.value)	
    });

    //  $(document).on("click", ".btnEditar", function(){		            
    //     // opcion='editar';
    //     fila = $(this);           
    //     // fila = $(this).closest("tr");	        
    //     // id = parseInt(fila.find('td:eq(0)').text());
    //     name = fila.find('td:eq(0)').text();
    //     console.log(name)
    //     // precio = fila.find('td:eq(2)').text();
    //     // stock = fila.find('td:eq(3)').text();            
    //     // $("#id").val(id);
    //     // $("#descripcion").val(descripcion);
    //     // $("#precio").val(precio);
    //     // $("#stock").val(stock);            
    //     // $(".modal-header").css("background-color", "#7303c0");
    //     // $(".modal-header").css("color", "white" );
    //     // $(".modal-title").text("Editar Artículo");		
    //     // $('#modalCRUD').modal('show');		   
    // });
});

const getRequests = async () => {
    const results = await getFileRequests("");
    filesClasification.value = results
    // console.log(filesClasification.value)
};


    
</script>
