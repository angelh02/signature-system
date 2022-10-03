import axios from "axios";

// GET ALL CONSERVATION TYPES
async function getAll() {
    return await axios
    .get(`/api/container/conservation-type/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET CONSERVATION TYPE BY ID
async function getOne(id) {
    return await axios
    .get(`/api/container/conservation-type/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW CONSERVATION TYPE
async function store(formData) {
    return await axios
    .post(`/api/container/conservation-type/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A CONSERVATION TYPE
async function drop(id){
    return await axios
    .delete(`/api/container/conservation-type/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A CONSERVATION TYPE
async function update(formData) {
    return await axios
    .post(`/api/container/conservation-type/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}