import axios from "axios";

// GET ALL CONSERVATION TIMES
async function getAll() {
    return await axios
    .get(`/api/container/conservation-time/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET CONSERVATION TIME BY ID
async function getOne(id) {
    return await axios
    .get(`/api/container/conservation-time/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW CONSERVATION TIME
async function store(formData) {
    return await axios
    .post(`/api/container/conservation-time/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// DELETE A CONSERVATION TIME
async function drop(id){
    return await axios
    .delete(`/api/container/conservation-time/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A CONSERVATION TIME
async function update(formData) {
    return await axios
    .post(`/api/container/conservation-time/update`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
  }

export default {getAll, getOne, store, drop, update}