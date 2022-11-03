import axios from "axios";

// GET ALL DOCUMENT TYPES
async function getAll() {
    return await axios
    .get(`/api/document-type/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET DOCUMENT TYPE BY ID
async function getOne(id) {
    return await axios
    .get(`/api/document-type/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW DOCUMENT TYPE
async function store(formData) {
    return await axios
    .post(`/api/document-type/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A DOCUMENT TYPE
async function drop(id){
    return await axios
    .delete(`/api/document-type/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A DOCUMENT TYPE
async function update(formData) {
    return await axios
    .post(`/api/document-type/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}