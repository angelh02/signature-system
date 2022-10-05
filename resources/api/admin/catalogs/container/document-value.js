import axios from "axios";

// GET ALL DOCUMENT VALUES
async function getAll() {
    return await axios
    .get(`/api/container/document-value/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET DOCUMENT VALUE BY ID
async function getOne(id) {
    return await axios
    .get(`/api/container/document-value/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW DOCUMENT VALUE
async function store(formData) {
    return await axios
    .post(`/api/container/document-value/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A DOCUMENT VALUE
async function drop(id){
    return await axios
    .delete(`/api/container/document-value/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A DOCUMENT VALUE
async function update(formData) {
    return await axios
    .post(`/api/container/document-value/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}