<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    public function lists(){
        $users = User::where('status',1)->orderBy('created_at','desc')->get()->toJson(JSON_PRETTY_PRINT);
        return response($users,200);
    }
    public function view($id){
        if(User::where('id',$id)->exists()){
            $user = User::where('id',$id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($user,200);
        }
        else{
            return response()->json([
                "message" => "Data not found"
            ],400);
        }
    }
    public function store(Request $req){
        $user = new User;
        $user->firstname = $req['firstname'];
        $user->lastname = $req['lastname'];
        $user->address = $req['address'];
        $user->postcode = $req['postcode'];
        $user->contact_number = $req['contact_number'];
        $user->username = $req['username'];
        $user->role = is_null($req['role']) ? 'standard' : $req['role'];
        $user->email = $req['email'];
        $user->status = 1;
        $user->password = Hash::make($req['password']);
        $user->save();

        $addedUser = User::find($user->id);
        $addedUser->token = $user->createToken('authToken')->accessToken;
        $addedUser->save();
            
        return response()->json([
            "message" => "User Created"
        ],201);
    }
    public function update(Request $req,$id){
        if(User::where('id',$id)->exists()){
            $user = User::find($id);
            $user->firstname = is_null($req->firstname) ? $user->firstname : $req['firstname'];
            $user->lastname = is_null($req->lastname) ? $user->lastname : $req['lastname'];
            $user->address = is_null($req->address) ? $user->address : $req['address'];
            $user->postcode = is_null($req->postcode) ? $user->postcode : $req['postcode'];
            $user->contact_number = is_null($req->contact_number) ? $user->contact_number : $req['contact_number'];
            $user->username = is_null($req->username) ? $user->username : $req['username'];
            $user->role = is_null($req->role) ? $user->role : $req['role'];
            $user->email = is_null($req->email) ? $user->email : $req['email'];
            $user->status = 1;
            $user->password = is_null($req->password) ? $user->password : Hash::make($req['password']);
            $user->save();
            return response()->json([
                "message" => "records updated successfully"
            ],200);
        }else{
            return response()->json([
                "message" => "user not found"
            ],404);
        }
    }
    public function delete($id){
        if(User::where('id',$id)->exists()){
            $user = User::find($id);
            $user->status = 0;
            $user->save();
            return response()->json([
                "message" => "user deleted"
            ],202);
        }else{
            return response()->json([
                "message" => "user not found"
            ],404);
        }
    }
}
