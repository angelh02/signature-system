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

// GET CONSERVATION TIMES
async function getConservationTimes() {
    return await axios
    .get(`/api/container/conservation-time/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// GET CONSERVATION TYPES
async function getConservationTypes() {
    return await axios
    .get(`/api/container/conservation-type/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// GET DOCUMENT VALUES
async function getDocumentValues() {
    return await axios
    .get(`/api/container/document-value/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// GET INFORMATION TYPES
async function getInformationTypes() {
    return await axios
    .get(`/api/container/information-type/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// GET SELECTION TECHNIQUES
async function getSelectionTechniques() {
    return await axios
    .get(`/api/container/selection-technique/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// CONTAINERS
// GET CONTAINERS
async function getContainers() {
    return await axios
    .get(`/api/container/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
// STORE CONTAINER
async function addContainer(formData) {
    return await axios
      .post(`/api/container/store`, formData, {
        headers: { 'content-type': 'multipart/form-data' },
      }
      )
      .then((res) => {
        if (res.status != 200) throw new Error("Response Failed");
        return res.data;
      })
  }
// UPDATE CONTAINER
async function editContainer(editData) {
  return await axios
    .post(`/api/container/update`, editData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
}
// Eliminar
async function deleteContainer(id) {
return await axios
  .delete(`/api/container/delete/`+id
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

export default {getContainers,getConservationTimes,getConservationTypes,getDocumentValues,getInformationTypes,getSelectionTechniques,addContainer,editContainer,deleteContainer}