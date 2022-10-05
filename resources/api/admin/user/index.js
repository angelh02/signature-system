import axios from "axios";

// const getFileRequests = async () => {
//     try {
//         const res = await axios.get(`/api/classification/background/get-all`);
//         return res;
//     } 
//     catch (err) {
//         console.error(err);
//     }
// };

// GET ALL DOCUMENTS
async function getAll() {
    return await axios
    .get(`/api/user/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET USER BY ID
async function getUser(id) {
    return await axios
    .get(`/api/user/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW USER
async function store(formData) {
    return await axios
    .post(`/api/user/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, UPDATE A USER
async function update(formData) {
  return await axios
  .post(`/api/user/update`,formData, {
    headers: { 'content-type': 'multipart/form-data' },
  }
  )
  .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
  })  
}
// DELETE A USER
async function drop(id){
    return await axios
    .delete(`/api/user/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, RESET PASSWORD TO SPECIFIC USER
async function resetPassword(formData) {
  return await axios
  .post(`/api/user/reset-password`,formData, {
    headers: { 'content-type': 'multipart/form-data' },
  }
  )
  .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
  })  
}

export default {getAll, getUser, store, update, drop, resetPassword}