<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return  $this->errorResponse('Unauthorized', 401);
    }


    public function me()
    {
        return $this->showDataResponse('user', $this->guard()->user());
    }


    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }


    public function guard()
    {
        return Auth::guard();
    }
}