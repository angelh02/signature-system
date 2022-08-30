import axios from "axios";

const Host  = 'https://127.0.0.1:8000'

// const getFileRequests = async () => {
//     try {
//         const res = await axios.get(`/api/classification/background/get-all`);
//         return res;
//     } 
//     catch (err) {
//         console.error(err);
//     }
// };


// Fondos
async function getBackground() {
    return await axios
    .get(`/api/classification/background/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// Secciones
async function getSection() {
    return await axios
    .get(`/api/classification/section/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// Produccion
async function getProductionArea() {
    return await axios
    .get(`/api/classification/production-area/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// Clasificaciones
async function getClasification() {
    return await axios
    .get(`/api/classification/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// Agregar 
async function addClassification(formData) {
    return await axios
      .post(`/api/classification/store`, formData, {
        headers: { 'content-type': 'multipart/form-data' },
      }
      )
      .then((res) => {
        if (res.status != 200) throw new Error("Response Failed");
        return res.data;
      })
  }
// Editar
async function editClassification(editData) {
  return await axios
    .post(`/api/classification/update`, editData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
}
// Eliminar
async function deleteClassification(id) {
return await axios
  .delete(`/api/classification/delete/`+id
  )
  .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
  })
}

// const deleteClassification = async (id) => {
//   try {
//     const res = await axios.delete(`/api/classification/delete/`+id);
//     return res.data;
//   } catch (error) {
//     console.log(error);
//   }
// }

export default {getClasification,getBackground,getSection,getProductionArea,addClassification,editClassification,deleteClassification}