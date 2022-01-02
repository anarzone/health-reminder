<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\PasswordRecoverService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PasswordRecoverController extends Controller
{
    public function __construct(private PasswordRecoverService $passwordRecoverService){}

    public function sendResetEmail(Request $request){
        Validator::make($request->all(), [
            'email' => 'required|email'
        ])->validate();

        $this->passwordRecoverService->handleResetEmail($request->input('email'));

        return Response::success([]);
    }

    public function resetPassword(Request $request){
        Validator::make($request->all(), [
            'email' => 'required|email|exists:password_resets,email',
            'token' => 'required|string',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ])->validate();

        $response = $this->passwordRecoverService->resetPassword($request->all());

        if($response){
            return Response::success([]);
        }

        return response([
            [
                'errors' => [
                    "token" => [
                        "Token is expired."
                    ]
                ]
            ],
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
