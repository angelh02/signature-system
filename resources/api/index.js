import axios from "axios";

const Host  = 'https://'

// const getFileRequests = async () => {
//     try {
//         const res = await axios.get(`${Host}pokeapi.co/api/v2/pokemon/`);
//         // const data = JSON.parse(res.data)
//         return res;
//     } 
//     catch (err) {
//         console.error(err);
//     }
// };

async function getFileRequests() {
    return await axios
    .get(`${Host}pokeapi.co/api/v2/pokemon/`, {
    headers: { 'content-type': 'application/json' },
    }
    )
    .then((res) => {
    if (res.status != 200) throw new Error("Response Failed");
    return res;
    })
    .then((res) => {
    return res.data;
    });
}

export default {getFileRequests}