import axios from "axios";

const Host  = 'https://127.0.0.1:8000'

axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

// SUBIR CERTIFICADOS
async function submitCertificates(certificateData) {
  return await axios
    .post(`/api/document/submit-certificates`, certificateData
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
}

//VERIFICAR CERTIFICADOS
async function checkCertificates(token){
  return await axios
    .post(`/api/user/check-certificates`, token)
    .then(res => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
    .catch(e => {
      console.log(e)
    });
}

//OBTENER LLAVE PARA SUBIR CERTIFICADOS
async function getUploadCertificateKey(token){
  return await axios
    .post(`/api/document/get-upload-key`, token)
    .then(res => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
}

//OBTENER URL DE DOCUMENTO ORIGINAL
async function getDocumentBase(documentId,token){
  return await axios
    .get(`http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Firmado/GetDocumentDetailById?DocumentID=${documentId}`,{headers : {
      'accept' : '*/*',
      'Authorization' : 'Bearer '+token
    }})
    .then(res => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data.urlDocumentoOriginal;
    })
}

//OBTENER URL DE DOCUMENTO ORIGINAL
async function getDocumentSigned(documentId,token){
  return await axios
    .get(`http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Firmado/GetDocumentDetailById?DocumentID=${documentId}`,{headers : {
      'accept' : '*/*',
      'Authorization' : 'Bearer '+token
    }})
    .then(res => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data.urlDocumentoFirmado;
    })
}
export default {checkCertificates,getUploadCertificateKey,submitCertificates,getDocumentBase,getDocumentSigned}