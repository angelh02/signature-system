import axios from "axios";

// GET ALL SELECTION TECHNIQUES
async function getAll() {
    return await axios
    .get(`/api/container/selection-technique/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET SELECTION TECHNIQUE BY ID
async function getOne(id) {
    return await axios
    .get(`/api/container/selection-technique/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW SELECTION TECHNIQUE
async function store(formData) {
    return await axios
    .post(`/api/container/selection-technique/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A SELECTION TECHNIQUE
async function drop(id){
    return await axios
    .delete(`/api/container/selection-technique/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A SELECTION TECHNIQUE
async function update(formData) {
    return await axios
    .post(`/api/container/selection-technique/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}