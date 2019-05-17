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
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
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
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['nombre'] =  $user->nombre;
        return response()->json(['exito'=>$success], $this->successStatus);
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
        return response()->json(['success' => $user], $this-> successStatus);
    }
}
