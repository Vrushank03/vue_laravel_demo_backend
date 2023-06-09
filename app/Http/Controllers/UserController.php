<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function userlogin(UserLoginRequest $request)
    {
        $check=User::where('email',$request->email)->first();
        if(!empty($check)){
            $statuscheck = User::where('email',$request->email)->where('status','1')->first();
            if(!empty($statuscheck)){
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    $userData = User::where('email',$request->email)->first();
                    return response()->json(['message'=>'Login Successfully!!','success'=>'1','token'=>$userData->createToken("API TOKEN")->plainTextToken]);
                }
                else{
                    return response()->json(['message'=>'Oops!! wrong email Id or password.','success'=>'0']);
                }
            }
            else{
                return response()->json(['message'=>'You are no longer user!!','success'=>'0']);
            }
       }
       else{
            return response()->json(['message'=>'You are not  registered user, please register yourself!!','success'=>'0']);
       }
    }

    public function getUser(){
        $user = User::get()->toJson();
        return $user;
    }

    public function createUser(CreateUserRequest $request){

        $data = $request->all();

        $createUserData =  User::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'phone_number'  => $data['phone_number'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'status'        => $data['status']
        ]);

        return response()->json(['currentaddedData'=> $createUserData,'message'=>'success']);
    }

    public function updateUser(UpdateUserRequest $request){

        $data = $request->all();

        $updateUserData = User::where('user_id',$request->id)->update([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'phone_number'  => $data['phone_number'],
            'email'         => $data['email'],
            'status'        => $data['status']
        ]);

        return response()->json(['updateUserData'=> $updateUserData,'message'=>'success']);
    }

    public function deleteUser($id){

        User::where('user_id',$id)->delete();

        return response()->json(['message'=>'success delete']);
    }

    public function uniquedata($id){

        $currentUserData = User::where('user_id',$id)->first();

        return response()->json(['userdataforupdate'=>$currentUserData]);
    }
}
