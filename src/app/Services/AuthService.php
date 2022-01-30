<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(private User $userModel){}

    public function login($data){
        if(Auth::attempt($data)){
            return $this->responseWithToken(Auth::user()->createToken('API Access Token')->plainTextToken);
        }

        return new Response([
            'status' => Response::HTTP_UNAUTHORIZED,
            'errors' => [
                'unauthorized_access' => 'Credentials not match'
            ]
        ],Response::HTTP_UNAUTHORIZED);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return Response::success([]);
    }

    private function responseWithToken($token){
        return Response::success([
            'access_token' => $token,
            'type' => 'Bearer',
        ]);
    }
}
