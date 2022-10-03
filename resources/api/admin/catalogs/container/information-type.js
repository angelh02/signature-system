import axios from "axios";

// GET ALL INFORMATION TYPES
async function getAll() {
    return await axios
    .get(`/api/container/information-type/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET INFORMATION TYPE BY ID
async function getOne(id) {
    return await axios
    .get(`/api/container/information-type/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW INFORMATION TYPE
async function store(formData) {
    return await axios
    .post(`/api/container/information-type/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A INFORMATION TYPE
async function drop(id){
    return await axios
    .delete(`/api/container/information-type/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A INFORMATION TYPE
async function update(formData) {
    return await axios
    .post(`/api/container/information-type/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}