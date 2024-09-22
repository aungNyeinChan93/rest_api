<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    //show users
    public function show()
    {
        $users = User::all();
        return response()->json([
            "message" => "Show users",
            "users" => $users,
        ], 200);
    }

    // register user
    public function register()
    {
       try {
        $validator = Validator::make(request()->all(), [
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required",
            "phone" => "required|min:4|max:15",
            "address" => "required",
            "role_id" => "nullable"

        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "validation fail",
                "errors" => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            "name" => request()->name,
            "email" => request()->email,
            "password" => Hash::make(request()->password),
            "phone" => request()->phone,
            "address" => request()->address,
            "role_id" => request()->role_id ?? 1,
        ]);

        $user->tokens()->delete();

        $token = $user->createToken("register-token")->plainTextToken;

        if ($token) {
            return response()->json([
                "message" => "User Create Success",
                "token" => $token,
            ]);
        }
       } catch (Exception $e) {
            return response()->json([
                "errors"=>$e->getMessage()
            ],422);
       }
    }

    // login
    public function login()
    {
        $validator = Validator::make(request()->all(),[
            "email"=> "required",
            "password"=>"required|",
        ]);

        if($validator->fails()){
            return response()->json([
                "mess"=>"login fail",
                "errors"=> $validator->errors(),
            ],422);
        };

        $user= User::where("email",request()->email)->first();

        $isPasswordCorrect = Hash::check(request()->password,$user->password);

        if(!$isPasswordCorrect){
            return response()->json([
                "message"=>"Password is incorrect",
            ],422);
        }

        $user->tokens()->delete();

        $token = $user->createToken("login-token")->plainTextToken;

        return response()->json([
            "message"=>"Login is success!",
            "login-token"=>$token,
        ]);

    }

    // update User Profile
    public function updateProfile(User $user){
        // dd($user->profile);
        // dd(request()->file("profile")->getClientOriginalName());

        $validator = Validator::make(request()->all(),[
            "profile"=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                "mess"=>"update fail",
                "errors"=> $validator->errors(),
            ],422);
        };

        if($user->id !== request()->user()->id){
            return response()->json([
                "message"=>" Not permission to accept!",
            ],403);
        }

        $oldFile = $user->profile;
        if($oldFile !== null){
            if(file_exists(public_path("/src/image/").$oldFile)){
                unlink(public_path("/src/image/").$oldFile);
            }
        }

        $fileName =request()->file("profile")->getClientOriginalName();
        request()->file("profile")->move(public_path()."/src/image/",$fileName);

        $user->update([
            "profile" => $fileName,
        ]);

        return response()->json([
            "message"=>"success update!"
        ]);

    }
}

