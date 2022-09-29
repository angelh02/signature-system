<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentSigned;
use App\Models\DocumentSigner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function assignSigner(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:10|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'document_id' => 'required|numeric|exists:documents,id',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Iniciamos nuestro nuevo documento
            $documentSigner = new DocumentSigner();
            //Capturamos los datos del nuevo documento
            $documentSigner->name = $request->input("name");
            $documentSigner->email = $request->input("email");
            $documentSigner->document_id = $request->input("document_id");
            //Guardamos los cambios
            $documentSigner->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info del documento creado
            $documentSigners = DocumentSigner::where("document_id","=",$documentSigner->document_id)->get();
            return response()->json($documentSigners, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

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
            $documentSigners = DocumentSigner::where("document_id","=",$documentSigner->document_id)->get();
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
            $documentSigners = DocumentSigner::where("document_id","=",$documentSigner->document_id)->get();
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
            $document->delete();
            DB::commit();
            return response()->json(["message" => "DOCUMENT_DELETED"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $documents = Document::with([
            "classification",
            "container",
            "documentType",
            "documentSigned",
            "documentSigners"
        ])->where([["canceled", null], ["canceled_at", null]])->get();

        return response()->json($documents, 200);
    }

    public function getDocument($id)
    {
        $document = Document::where("id", $id)
        ->where([["canceled", null], ["canceled_at", null]])
        ->with([
            "classification",
            "container",
            "documentType",
            "documentSigned",
            "documentSigners"
        ])->first();

        return response()->json($document, 200);
    }

    public function signDocument(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:documents,id',
            'pdf_url' => 'required',
            'xml_url' => 'required'
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
            $document->signed = true;
            $currentDate = date("Y-m-d");
            $document->signed_at = $currentDate;
            $document->updated_at = $currentDate;
            //Guardamos los cambios
            $document->save();

            //Cambiamos a true los firmantes
            foreach ($document->documentSigners() as $key => $signer) {
                $signer->signed = true;
                $signer->signed_at = $currentDate;
                $signer->save();
            }

            //Creamos la data del documento ya firmado
            $documentSigned = new DocumentSigned();
            $documentSigned->document_id = $document->id;
            $documentSigned->pdf_url = $request->input("pdf_url");
            $documentSigned->xml_url = $request->input("xml_url");
            $documentSigned->save();

            DB::commit();

            //Cargamos las relaciones para retornar la info del documento modificado
            $document->load([
                "container",
                "classification",
                "documentType",
                "documentSigned",
                "documentSigners"
            ]);
            return response()->json($document, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:10|max:30',
            'container_id' => 'required|numeric|exists:containers,id',
            'classification_id' => 'required|numeric|exists:classifications,id',
            'document_type_id' => 'required|numeric|exists:document_types,id',
            'url' => 'required',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //extraemos el usuario que crea el documento
            $user = Auth::user();
            //Iniciamos nuestro nuevo documento
            $document = new Document();
            //Capturamos los datos del nuevo documento
            $document->name = $request->input("name");
            $document->user_id = /* $user->id */1;
            $document->container_id = $request->input("container_id");
            $document->classification_id = $request->input("classification_id");
            $document->document_type_id = $request->input("document_type_id");
            $document->url = $request->input("url");
            $currentDate = date("Y-m-d");
            $effectiveDate = date("Y-m-d", strtotime($currentDate. ' + 15 days'));
            $document->effective_date = $effectiveDate;
            $document->created_at = $currentDate;
            $document->updated_at = $currentDate;
            //Guardamos los cambios
            $document->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info del documento creado
            $document->load([
                "container",
                "classification",
                "documentType",
                "documentSigned",
                "documentSigners"
            ]);
            return response()->json($document, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:documents,id',
            'name' => 'required|min:10|max:30',
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
            $document->name = $request->input("name");
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
                "documentSigners"
            ]);
            return response()->json($document, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }
}
