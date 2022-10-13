<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','logout']]);
    }

    
    public function login()
    {
       
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {

            return response()->json(['error' => 'Login Gagal'], 401);
        
        }

        return $this->respondWithToken($token);
    }

   
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function mes($token)
    {
        return $this->respondWithToken($token);
    }

  
    public function logout()
    {
      
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

 
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 120000
        ]);
    }
}