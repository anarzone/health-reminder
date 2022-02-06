<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\PasswordRecoverService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PasswordRecoverController extends Controller
{
    public function __construct(private PasswordRecoverService $passwordRecoverService)
    {
    }

    public function sendResetEmail(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email'
        ])->validate();

        $this->passwordRecoverService->handleResetEmail($request->input('email'));

        return Response::success([]);
    }

    public function verifyPassword(Request $request): Response
    {
        $request->validate([
            'otp_token' => 'required|string',
        ]);

        $response = $this->passwordRecoverService->verifyPassword($request->all());

        if ($response) {
            return Response::success([]);
        }

        return new Response([
            [
                'errors' => [
                    'otp_token' => [
                        'Otp token is false or expired.'
                    ]
                ]
            ],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function resetPassword(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email|exists:password_resets,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ])->validate();

        $this->passwordRecoverService->resetPassword($request->all());

        return Response::success([]);
    }
}
