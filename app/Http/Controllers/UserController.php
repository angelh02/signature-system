<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
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
            $user->active = Hash::make('contraseña');
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
            'name' => 'required|min:10|max:255',
            'surnames' => 'required|min:10|max:255',
            'user_name' => 'required|min:5|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email',
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
            //Create new user 
            $user = new User();
            $user->name = $request->input('name');
            $user->surnames = $request->input('surnames');
            $user->user_name = $request->input('user_name');
            $user->email = $request->input('email');
            $user->active = $request->input('active');
            $user->password = Hash::make('contraseña');
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
            'name' => 'required|min:10|max:255',
            'surnames' => 'required|min:10|max:255',
            'user_name' => 'required|min:5|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email,' . $request->input('id'),
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
            $user->email = $request->input('email');
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
