<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    //store role
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "name"=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                "errors"=> $validator->errors()
            ]);
        }

        $role = Role::create([
            "name"=>$request->name
        ]);

        return response()->json([
            "message" =>"Role create success!",
            "role"=>$role
        ]);
    }

    // show roles
    public function show(){
        $roles = Role::all();

        if($roles->first() == null){
            return response()->json(
               [
                 "error" => "Empty Role"
               ]
            );
        }

        return response()->json([
            "roles"=>$roles
        ],200);
    }

    // destory role
    public function destory(Role $role){

        $role->delete();
        return response()->json([
            "message"=>"role delete success!"
        ]);
    }

    // update role
    public function update(Role $role,Request $request){
        $validator = Validator::make($request->all(),[
            "name"=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                "errors"=> $validator->errors()
            ]);
        }

        $role->update([
            "name"=>$request->name
        ]);

        return response()->json([
            "message"=>"Role update success!",
            "role"=>$role,
        ]);
    }
}
