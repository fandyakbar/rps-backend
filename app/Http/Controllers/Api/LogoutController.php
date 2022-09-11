<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Tymon\JWTAuth\Facades\JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredExecption;
use Tymon\JWTAuth\Exceptions\TokenInvalidExecption;


class LogoutController extends Controller
{

    public function __invoke(Request $request)
    {
        $removetoken = JWTAuth::Invalidate(JWTAuth::getToken());

        if ($removetoken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil',
            ]);
        }
    }
}
