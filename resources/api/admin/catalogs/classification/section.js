import axios from "axios";

// GET ALL SECTIONS
async function getAll() {
    return await axios
    .get(`/api/classification/section/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET SECTION BY ID
async function getOne(id) {
    return await axios
    .get(`/api/classification/section/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW SECTION
async function store(formData) {
    return await axios
    .post(`/api/classification/section/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A SECTION
async function drop(id){
    return await axios
    .delete(`/api/classification/section/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A SECTION
async function update(formData) {
    return await axios
    .post(`/api/classification/section/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}