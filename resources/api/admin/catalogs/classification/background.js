import axios from "axios";

// GET ALL BACKGROUNDS
async function getAll() {
    return await axios
    .get(`/api/classification/background/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET BACKGROUND BY ID
async function getOne(id) {
    return await axios
    .get(`/api/classification/background/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW BACKGROUND
async function store(formData) {
    return await axios
    .post(`/api/classification/background/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A BACKGROUND
async function drop(id){
    return await axios
    .delete(`/api/classification/background/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A BACKGROUND
async function update(formData) {
    return await axios
    .post(`/api/classification/background/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}