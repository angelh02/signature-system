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

// GET ALL DELETION REQUESTS
async function getAll() {
    return await axios
    .get(`/api/deletion-request/get-all`, 
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// GET DELETION REQUEST BY ID
async function getDeletionRequest(id) {
    return await axios
    .get(`/api/deletion-request/get/${id}`,
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, CREATE A NEW DELETION REQUEST
async function store(formData) {
    return await axios
    .post(`/api/deletion-request/store`,formData, {
      headers: { 'content-type': 'multipart/form-data' },
    }
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}
// POST, ACCEPT A DELETION REQUEST
async function acceptRequest(formData) {
  return await axios
  .post(`/api/deletion-request/accept`,formData, {
    headers: { 'content-type': 'multipart/form-data' },
  }
  )
  .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
  })  
}
// POST, REJECT A DELETION REQUEST
async function rejectRequest(formData) {
  return await axios
  .post(`/api/deletion-request/reject`,formData, {
    headers: { 'content-type': 'multipart/form-data' },
  }
  )
  .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res.data;
  })  
}
// DELETE A DELETION REQUEST
async function drop(id){
    return await axios
    .delete(`/api/deletion-request/delete/${id}`
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })  
}

export default {getAll, getDeletionRequest, store, acceptRequest, rejectRequest, drop}