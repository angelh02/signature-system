<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentSigned;
use App\Models\DocumentSigner;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use App\Http\Requests\MultipartFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function assignSigner(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:users,id',
            'document_id' => 'required|numeric|exists:documents,id',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Iniciamos nuestro nuevo documento
            $documentSigner = new DocumentSigner();
            //Capturamos los datos del nuevo documento
            $documentSigner->user_id = $request->input("user_id");
            $documentSigner->document_id = $request->input("document_id");
            //Guardamos los cambios
            $documentSigner->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info del documento creado
            $documentSigners = DocumentSigner::where("document_id","=",$documentSigner->document_id)->with('user')->get();
            return response()->json($documentSigners, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    //Contacta al dueño del documento en caso de que halla un problema con el documento
    public function contactDocumentOwner(Request $request){
        $validator = Validator::make($request->all(), [
            'user_email' => 'required|email:rfc,dns|max:255|exists:users,email',
            'document_id' => 'required|numeric|exists:documents,id',
            'subject' => 'required|min:10|max:255',
            'description' => 'required|min:10'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            $user = User::where('email', $request->input('email'))->first();
            $document = Document::where('id', $request->input('user_id'))->first();

            /* sendMailToDocumentOwner(json_encode([
                "user" => $user,
                "document" => $document,
                "messageData" => [
                    "subject" => $request->input('subject'),
                    "description" => $request->input('description')
                ]
            ]), 0); */
            
            return response()->json(["message" => "OK"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    //This function does not use
    public function editSigner(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:document_signer,id',
            'name' => 'required|min:10|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'document_id' => 'required|numeric|exists:documents,id',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Iniciamos nuestro nuevo documento
            $documentSigner = DocumentSigner::where("id","=",$request->input("id"))->first();
            if($documentSigner == null)
                return response()->json(["message" => "SIGNER_DOES_NOT_EXISTS"], 402);
            //Capturamos los datos del nuevo documento
            $documentSigner->name = $request->input("name");
            $documentSigner->email = $request->input("email");
            $documentSigner->document_id = $request->input("document_id");
            //Guardamos los cambios
            $documentSigner->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info del documento creado
            $documentSigners = DocumentSigner::where("document_id","=",$documentSigner->document_id)->with('user')->get();
            return response()->json($documentSigners, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function deleteSigner($id){
        try {
            DB::beginTransaction();
            //Iniciamos nuestro nuevo documento
            $documentSigner = DocumentSigner::where("id","=",$id)->first();
            if($documentSigner == null)
                return response()->json(["message" => "SIGNER_DOES_NOT_EXISTS"], 402);
            //Elimina el registro
            $documentSigner->delete();
            DB::commit();

            //Cargamos las relaciones para retornar la info del documento creado
            $documentSigners = DocumentSigner::where("document_id","=",$documentSigner->document_id)->with('user')->get();
            return response()->json($documentSigners, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            DB::beginTransaction();
            //Consulta el documento con el id recibido
            $document = Document::where("id", $id)->first();
            if($document == null)
                return response()->json(["message" => "DOCUMENT_DOES_NOT_EXISTS"], 402);
            //Elimina el registro
            $document->canceled = true;
            $document->canceled_at = date('Y-m-d');
            $document->save();
            DB::commit();
            return response()->json(["message" => "DOCUMENT_DELETED"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }
    
    public function getDocumentsByIds(Request $request){
        $validator = Validator::make($request->all(), [
            'documents' => 'required|array|min:1',
            'documents.*' => 'required|numeric|exists:documents,id'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $documents = Document::with([
            "classification",
            "container",
            "documentType",
            "documentSigned",
            "user",
            "documentSigners.user",
        ])->where([["canceled", false], ["canceled_at", null]])->whereIn('id', $request->input('documents'))->get();
        
        return response()->json($documents, 200);
    }

    public function getUserSignDocuments(int $userId){
        $documents = Document::with([
            "classification",
            "container",
            "documentType",
            "documentSigned",
            "documentSigners" => function($query) use($userId){
                $query->where('user_id',$userId);
            },
            "documentSigners.user",
            "deletionRequests" => function($query){
                $query->where("status", "Pendiente");
            }
        ])->where([["canceled", false], ["canceled_at", null]])->whereHas('documentSigners', function($query) use($userId) {
            $query->where('user_id', $userId);
        })->get();
        
        return response()->json($documents, 200);
    }

    public function getUserDocuments(int $userId){
        $documents = Document::with([
            "classification",
            "container",
            "documentType",
            "documentSigned",
            "documentSigners" => function($query) use($userId){
                $query->where('user_id',$userId);
            },
            "documentSigners.user",
            "deletionRequests" => function($query){
                $query->where("status", "Pendiente");
            }
        ])->where([["canceled", false], ["canceled_at", null], ["user_id", $userId]])->get();
        
        return response()->json($documents, 200);
    }

    public function getAll()
    {
        $documents = Document::with([
            "classification",
            "container",
            "documentType",
            "user",
            "documentSigned",
            "documentSigners.user",
            "deletionRequests" => function($query){
                $query->where("status", "Pendiente");
            }
        ])->where([["canceled", false], ["canceled_at", null]])->get();
        
        return response()->json($documents, 200);
    }

    public function getDocument($id)
    {
        $document = Document::where("id", $id)
        ->where([["canceled", false], ["canceled_at", null]])
        ->with([
            "classification",
            "container",
            "documentType",
            "user",
            "documentSigned",
            "documentSigners.user",
            "deletionRequests" => function($query){
                $query->where("status", "Pendiente");
            }
        ])->first();

        return response()->json($document, 200);
    }

    //Get key with uuid
    public function getUploadCertificateKey(Request $request){
        $validator = Validator::make($request->all(), [
            'aws_token' => 'required',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        //Get Key
        $uuid = strtoupper(guidv4());
        $client = new Client();

        $url = "http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Certificados/GetKeyToUploadCertificate";
        $headers = [
            'Accept' => '*/*',
            'Authorization' => 'Bearer '.$request->input('aws_token')
        ];
        $query = [
            'key' => $uuid
        ];

        $response = $client->request('GET', $url, [
            'query' => $query,
            'headers' => $headers,
            'verify'  => false,
        ]);
        if($response->getStatusCode() != 200)
            return response()->json(["status" => $response->getStatusCode(), "message" => "No Autorizado"], $response->getStatusCode());

        $responseBody = json_decode($response->getBody());
        
        return response()->json([
            "uuid" => $uuid,
            "data" => $responseBody
        ], 200);
    }

    //Manda un recordatorio a un usuario seleccionado
    public function remindSigner(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric|exists:users,id',
            'document_id' => 'required|numeric|exists:documents,id'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);

        try {
            $user = User::where('id', $request->input('user_id'))->with([
                'documentsToSign.document', 
                'documentsToSign' => function($query) use($request){
                    $query->where('document_id', $request->input('document_id'));
                }])->first();
            //sendMailToRemindSigner($user->toJson(),0);
            return response()->json(["message" => "OK"], 200);
        } catch (\Exception $e) {
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    //Marca como firmado un documento
    public function signDocument(Request $request){
        $validator = Validator::make($request->all(), [
            'aws_token' => 'required',
            'user_id' => 'required|numeric|exists:users,id',
            'documents' => 'required|array|min:1',
            'documents.*' => 'required|numeric|exists:documents,id',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        try {
            DB::beginTransaction();
            //Consultamos el documento por su id
            $documentSigners = DocumentSigner::with('document')->whereIn("document_id", $request->input("documents"))->where('user_id', $request->input('user_id'))->get();
            if($documentSigners == null || count($documentSigners) == 0)
                return response()->json(["message" => "DOCUMENTS_DOES_NOT_EXISTS"], 402);
            //Integracion con aws al momento de firmar retornar los urls de los archivos
            $awsDocumentIds = [];
            foreach($documentSigners as $key => $documentSigner){
                $documentSigner->signed = true;
                $documentSigner->signed_at = date('Y-m-d');
                $documentSigner->save();
                array_push($awsDocumentIds, $documentSigner->document->aws_document_id);
            }
            //Sign Documents AWS
            $client = new Client();
            $url = "http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Firmado/ConfirmMultipleSign";
            $headers = [
                'Accept' => '*/*',
                'Authorization' => 'Bearer '.$request->input('aws_token'),
            ];

            $response = $client->request('POST', $url, [
                'json' => $awsDocumentIds,
                'headers' => $headers,
                'verify'  => false,
            ]);
            if($response->getStatusCode() != 200)
                return response()->json(["status" => $response->getStatusCode(), "message" => "No Autorizado"], $response->getStatusCode());

            $responseBody = json_decode($response->getBody());

            $documentsSigned = intval(explode(' ', $responseBody->message)[2]);
            //SignDocument
            $documents = Document::whereIn("id", $request->input("documents"))->whereDoesntHave('documentSigners', function($query){
                $query->where('signed', false)->where('signed_at', null);
            })->get();
            if($documentsSigned < count($documents))
                return response()->json(["message" => "No se firmaron los documentos"], 422);
            foreach($documents as $key => $document){
                //Capturamos los datos a editar del documento
                $document->signed = true;
                $currentDate = date("Y-m-d");
                $document->signed_at = $currentDate;
                $document->updated_at = $currentDate;
                //Guardamos los cambios
                $document->save();

                //Creamos la data del documento ya firmado
                $documentSigned = new DocumentSigned();
                $documentSigned->document_id = $document->id;
                $documentSigned->pdf_url = "https://drive.google.com/uc?id=1e4Pg3SkXZh6NEldfTNTUmzTGxE3VQlvd&export=download";
                $documentSigned->xml_url = "https://drive.google.com/uc?id=1e4Pg3SkXZh6NEldfTNTUmzTGxE3VQlvd&export=download";
                $documentSigned->save();

                //sendMailToSignDocument($document->load('user'),0);
            }

            $user = User::where('id', $request->input('user_id'))->with([
                'documentsToSign.document', 
                'documentsToSign' => function($query) use($request){
                    $query->whereIn('document_id', $request->input('documents'));
                }])->first();
            //sendMailToSignConfirmation($user->toJson(), 0);

            DB::commit();

            //Cargamos las relaciones para retornar la info del documento modificado
            return response()->json(["status" => "OK"], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aws_token' => 'required',
            'user_id' => 'required|numeric|exists:users,id',
            'document_name' => 'required|min:10|max:255',
            'aws_document_id' => 'required|numeric',
            'url' => 'required',
            'signers' => 'required|array|min:1',
            'signers.*.user_id' => 'required|numeric|exists:users,id',
            'signers.*.email' => 'required|email:rfc,dns|max:255|exists:users,email',
            'signers.*.name' => 'required|min:4|max:255',
            'signers.*.surnames' => 'required|min:4|max:255',
            'container_id' => 'required|numeric|exists:containers,id',
            'classification_id' => 'required|numeric|exists:classifications,id',
            'document_type_id' => 'required|numeric|exists:document_types,id',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Iniciamos nuestro nuevo documento
            $document = new Document();

            //ID del documento creado en aws
            $document->aws_document_id = $request->input('aws_document_id');
            $document->name = $request->input('document_name');
            $document->user_id = $request->input('user_id');
            $document->container_id = $request->input('container_id');
            $document->classification_id = $request->input('classification_id');
            $document->document_type_id = $request->input('document_type_id');
            /* $document->url = $documentInput['data'); */
            $document->url = $request->input('url');
            $currentDate = date("Y-m-d");
            $effectiveDate = date("Y-m-d", strtotime($currentDate. ' + 15 days'));
            $document->effective_date = $currentDate;
            $document->created_at = $currentDate;
            $document->updated_at = $currentDate;
            //Guardamos los cambios
            $document->save();

            //Add signers
            foreach ($request->input('signers') as $key => $signer) {
                $documentSigner = new DocumentSigner();
                $documentSigner->user_id = $signer['user_id'];
                $documentSigner->document_id = $document->id;
                $documentSigner->save();
            }
            //sendMailToSigners($document-load('container', 'classification', 'documentType', 'documentSigners.user')->toJson(), 0);
            
            //Se confirman los cambios en la base de datos
            DB::commit();

            return response()->json($document, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    //Sube los certificados con el api de AWS
    public function submitCertificates(Request $request){
        $validator = Validator::make($request->all(), [
            'aws_token' => 'required',
            'cer_file' => 'required',
            'key_file' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);

    
        //Submit Certificates  
        $client = new Client();
        $url = "http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/Certificados";
        $headers = [
            'Accept' => '*/*',
            'Authorization' => 'Bearer '.$request->input('aws_token'),
            'Password' => $request->input('password')
        ];
        $query = [
            'IdRequest' => ""//idrequest
        ];
        $json = [
            'filecer' => $request->input("cer_file"),
            'fileKey' => $request->input("key_file")
        ];

        $response = $client->request('POST', $url, [
            'query' => $query,
            'json' => $json,
            'headers' => $headers,
            'verify'  => false,
        ]);
        if($response->getStatusCode() != 200)
            return response()->json(["status" => $response->getStatusCode(), "message" => "No Autorizado"], $response->getStatusCode());

        $responseBody = json_decode($response->getBody());

        if(count($responseBody) == 0)
            return response()->json(["status" => false], 200);

        return response()->json(["status" => true], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:documents,id',
            'container_id' => 'required|numeric|exists:containers,id',
            'classification_id' => 'required|numeric|exists:classifications,id',
            'document_type_id' => 'required|numeric|exists:document_types,id',
            'url' => 'required'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Consultamos el documento por su id
            $document = Document::where("id", $request->input("id"))->first();
            if($document == null)
                return response()->json(["message" => "DOCUMENT_DOES_NOT_EXISTS"], 402);
            //Capturamos los datos a editar del documento
            $document->container_id = $request->input("container_id");
            $document->classification_id = $request->input("classification_id");
            $document->document_type_id = $request->input("document_type_id");
            $document->url = $request->input("url");
            $currentDate = date("Y-m-d");
            $document->updated_at = $currentDate;
            //Guardamos los cambios
            $document->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info del documento modificado
            $document->load([
                "container",
                "classification",
                "documentType",
                "documentSigned",
                "documentSigners.user"
            ]);
            return response()->json($document, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }
}
