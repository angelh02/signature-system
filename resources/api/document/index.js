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


// CONTAINERS
// GET TYPE DOCUMENT
async function getDocumentsType() {
  return await axios
  .get(`/api/document-type/get-all`, 
  // {
  // headers: { 'content-type': 'application/json' },
  // }
  )
  .then((res) => {
  if (res.status != 200) throw new Error("Response Failed");
  return res.data;
  })  
}
// GET DOCUMENTS
async function getDocuments() {
    return await axios
    .get(`/api/document/get-all`, 
    // {
    // headers: { 'content-type': 'application/json' },
    // }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
    })  
}
//GET DOCUMENT
async function getDocument(id){
  return await axios
    .get('/api/document/get/'+id)
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
}
// STORE CONTAINER
async function addDocument(formData) {
    return await axios
      .post(`/api/document/store`, formData, {
        headers: { 'content-type': 'multipart/form-data' },
      }
      )
      .then((res) => {
        if (res.status != 200) throw new Error("Response Failed");
        return res.data;
      })
  }
// UPDATE CONTAINER
async function editDocument(editData) {
  return await axios
    .post(`/api/document/update`, editData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
}
// Eliminar
async function deleteDocument(id) {
return await axios
  .delete(`/api/document/delete/`+id
  )
  .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
  })
}
// FRIMANTES
// AGReGAR FIRMANTE
async function addSigned(formData) {
  return await axios
    .post(`/api/document/signer/assign`, formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
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

export default {getDocument,getDocuments,addDocument,editDocument,deleteDocument,getDocumentsType,addSigned}