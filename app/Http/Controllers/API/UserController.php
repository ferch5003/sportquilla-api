<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

public $successStatus = 200;

/**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $user = User::where('email' , $request->email)
        ->first();
        $email = $request->email;
        if($user && password_verify($request->password, $user->password)){
            $user->email = $email;
            return response()->json(['success' => $user], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
/**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //$success['token'] =  $user->createToken('MyApp')->accessToken;
        $email = $request->email;
        $user->email = $email;
        return response()->json(['exito'=> $user], $this->successStatus);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        if(isset($input['password'])){
            $input['password'] = bcrypt($input['password']);
        }
        User::findOrFail($id)->
            update($input);
        $user = User::where('email',$id)->first();
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['nombre'] =  $user->nombre;
        return response()->json(['exito'=>$success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
