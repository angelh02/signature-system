<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //Verifica que el usuario ya halla subido sus certificados
    public function checkCertificates(Request $request){
        $validator = Validator::make($request->all(), [
            'aws_token' => 'required'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        $client = new Client();

        $url = "https://firmaelectronica.mxteam23.com/Certificados";
        $headers = [
            'Accept' => '*/*',
            'Authorization' => 'Bearer '.$request->input('aws_token')
        ];

        $response = $client->request('GET', $url, [
            'headers' => $headers,
            'verify'  => false,
        ]);
        if($response->getStatusCode() != 200)
            return response()->json(["status" => $response->getStatusCode(), "message" => "No Autorizado"], $response->getStatusCode());

        $responseBody = json_decode($response->getBody());

        if(count($responseBody) < 1)
            return response()->json(["status" => false], 200);

        return response()->json(["status" => true], 200);
    }

    public function delete($id){
        try {
            DB::beginTransaction();
            $user = User::where('id',$id)->first();
            if(!$user)
                return response()->json(['message' => 'USER_DOES_NOT_EXIST'], 422);
            $user->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getRoles(){
        $roles = Role::all();

        return response()->json($roles, 200);
    }

    public function getAll()
    {
        $users = User::with('roles')->get();

        return response()->json($users, 200);
    }

    public function getUser($id)
    {
        $user = User::where("id", $id)->with('roles')->first();

        return response()->json($user, 200);
    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:users,id'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Updating user 
            $user = User::where('id',$request->input('id'))->first();
            if(!$user)
                return response()->json(['message' => 'USER_DOES_NOT_EXIST'], 200);
            $user->password = Hash::make('ITSL@2022');
            $user->save();
            DB::commit();
            return response()->json($user, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'aws_token' => 'required',
            'name' => 'required|min:4|max:255',
            'surnames' => 'required|min:4|max:255',
            'user_name' => 'required|min:5|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email',
            'RFC' => 'required|min:13|max:13|unique:users,rfc',
            'active' => 'required|boolean',
            'role_id' => 'required|exists:roles,id'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //AWS IMPLEMENTATION
            $client = new Client();

            $url = "https://firmaelectronica.mxteam23.com/api/Users/AddUser";
            $headers = [
                'Accept' => '*/*',
                'Authorization' => 'Bearer '.$request->input('aws_token')
            ];

            $queryParameters = [
                "rfc" => $request->input('RFC'),
                "fullname" => $request->input('name').' '.$request->input('surnames'),
                "UserName" => $request->input('email')
            ];

            $response = $client->request('POST', $url, [
                'query' => $queryParameters,
                'headers' => $headers,
                'verify'  => false,
            ]);
            if($response->getStatusCode() != 200)
                return response()->json(["status" => $response->getStatusCode(), "message" => "No Autorizado"], $response->getStatusCode());

            $responseBody = json_decode($response->getBody());
            $requestArray = explode(' ', $responseBody->message);

            $userAwsId = intval($requestArray[count($requestArray)-1]);

            $userRole = Role::where('id', $request->input('role_id'))->first();
            if(!$userRole)
                return response()->json(['message' => 'ROLE_DOES_NOT_EXIST'], 200);
            //Create new user 
            $user = new User();
            //Id of user created in AWS BD
            $user->aws_user_id = $userAwsId;
            $user->name = $request->input('name');
            $user->surnames = $request->input('surnames');
            $user->user_name = $request->input('user_name');
            $user->RFC = $request->input('RFC');
            $user->email = $request->input('email');
            $user->active = $request->input('active');
            $user->password = Hash::make('ITSL@2022');
            $user->save();

            //Asign role to new user
            $user->assignRole($userRole);
            DB::commit();
            return response()->json($user, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:users,id',
            'name' => 'required|min:4|max:255',
            'surnames' => 'required|min:4|max:255',
            'user_name' => 'required|min:5|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email,' . $request->input('id'),
            'RFC' => 'required|min:13|max:13|unique:users,rfc,' . $request->input('id'),
            'active' => 'required|boolean',
            'role_id' => 'required|exists:roles,id'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $userRole = Role::where('id', $request->input('role_id'))->first();
            if(!$userRole)
                return response()->json(['message' => 'ROLE_DOES_NOT_EXIST'], 200);
            //Updating user 
            $user = User::where('id',$request->input('id'))->first();
            if(!$user)
                return response()->json(['message' => 'USER_DOES_NOT_EXIST'], 200);
            $user->name = $request->input('name');
            $user->surnames = $request->input('surnames');
            $user->user_name = $request->input('user_name');
            $user->RFC = $request->input('RFC');
            //$user->email = $request->input('email');
            $user->active = $request->input('active');
            $user->save();

            //Asign role to user
            if(!$user->hasRole($userRole))
                $user->syncRoles($userRole);
            DB::commit();
            return response()->json($user, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
