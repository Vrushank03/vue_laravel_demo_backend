<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;




class UserController extends Controller
{
    public function userlogin(UserLoginRequest $request)
    {
        $user=User::where('email',$request->email)->first();

        if(!empty($user)){

                $statuscheck = $user->where('status','1')->first();

                if(!empty($statuscheck)){

                    $credentials = $request->only('email', 'password');

                    if (Auth::attempt($credentials)) {

                        return response()->json(['message'=>'Login Successfully!!','success'=>'1','token'=>$user->createToken("API TOKEN")->plainTextToken]);

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

        $createUserData =  User::create($data);

        return response()->json(['currentaddedData'=> $createUserData,'message'=>'success']);
    }

    public function updateUser(UpdateUserRequest $request){

        $data = $request->all();

        $user = User::where('user_id',$request->user_id)->first();
        $message = null;

        if(!empty($user)){

            $user = $user->update($data);
            $user = User::find($request->user_id);
            $message = 'Success';
        }
        else{

            $message = 'User is not exits!!';
        }

        return response()->json(['updateUserData'=> $user,'message'=>$message]);
    }

    public function deleteUser($id){

        $user = User::where('user_id',$id)->fisrt();
        $message = null;

        if(!empty($user)){

            $user->delete();
            $message = 'Success';
        }
        else{

            $message = 'User is not exit!!';

        }

        return response()->json(['message'=>$message]);

    }

    public function uniquedata($id){

        $currentUserData = User::where('user_id',$id)->first();

        return response()->json(['userdataforupdate'=>$currentUserData]);
    }

    public function userlogout()
    {
        $user = Auth::user();

        if ($user) {

            $token = $user->currentAccessToken();
            $token->delete();
        }

        Session::flush();
        Auth::logout();

        return response()->json(['message'=>'Logout']);
    }

}
