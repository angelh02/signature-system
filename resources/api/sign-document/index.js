import axios from "axios";

const Host  = 'https://127.0.0.1:8000'

axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

// SUBIR CERTIFICADOS
async function submitCertificates1(certificateData) {
  return await axios
    .post(`/api/document/submit-certificates`, certificateData
    )
    .then((res) => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
}
// SUBIR CERTIFICADOS
async function submitCertificates(token, password, idRequest, data) {
  let headersL = {
      'content-type': 'multipart/form-data',
      'accept' : '*/*',
      'Authorization' : 'Bearer '+token,
      'Password' : password
  };
  return await axios
    .post(`http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Certificados?IdRequest=${idRequest}`, data,{headers : headersL})
    .then(res => {
        return res;
    })
    .catch(e => {
        return e;
    });
}

// SUBIR DOCUMENTO
async function submitDocument(token, signers, data) {
  let headersL = {
      'content-type': 'multipart/form-data',
      'accept' : '*/*',
      'Authorization' : 'Bearer '+token,
      'IdUsers' :  signers
  };
  return await axios
    .post(`http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Firmado/SignDocumentWithMultipleRFC`, data,{headers : headersL})
    .then(res => {
        if (res.status != 200) throw new Error("Response Failed");
        return res.data;
    })
    .catch(e => {
        return e;
    });
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

//OBTENER LISTA DE DOCUMENTOS DONDE PARTICIPAS
async function getSignedDocuments(token){
  let headersL = {
      'content-type': 'multipart/form-data',
      'accept' : '*/*',
      'Authorization' : 'Bearer '+token,
  };
  return await axios
    .get(`http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Firmado/GetDocumentsByUser`, {headers : headersL})
    .then(res => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data;
    })
    .catch(e => {
      console.log(e)
    });
}

//OBTENER LISTA DE DOCUMENTOS POR USUARIO
async function getUserDocuments(token){
  let headersL = {
      'content-type': 'multipart/form-data',
      'accept' : '*/*',
      'Authorization' : 'Bearer '+token,
  };
  return await axios
    .get(`http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Firmado/GetDocumentsCreatedByUser`, {headers : headersL})
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
async function getPrintDocument(documentId,token){
  return await axios
    .get(`http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Firmado/GetDocumentDetailById?DocumentID=${documentId}`,{headers : {
      'accept' : '*/*',
      'Authorization' : 'Bearer '+token
    }})
    .then(res => {
      if (res.status != 200) throw new Error("Response Failed");
      return res.data.urlConstancia;
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
export default {checkCertificates,getUploadCertificateKey,submitCertificates,getSignedDocuments,getUserDocuments,getDocumentBase,getPrintDocument,getDocumentSigned,submitDocument}