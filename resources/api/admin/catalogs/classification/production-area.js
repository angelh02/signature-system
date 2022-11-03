import axios from "axios";

// GET ALL PRODUCTION AREAS
async function getAll() {
    return await axios
    .get(`/api/classification/production-area/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET PRODUCTION AREA BY ID
async function getOne(id) {
    return await axios
    .get(`/api/classification/production-area/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW PRODUCTION AREA
async function store(formData) {
    return await axios
    .post(`/api/classification/production-area/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A PRODUCTION AREA
async function drop(id){
    return await axios
    .delete(`/api/classification/production-area/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A PRODUCTION AREA
async function update(formData) {
    return await axios
    .post(`/api/classification/production-area/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}