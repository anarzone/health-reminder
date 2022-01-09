<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAccountService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function __construct(public SocialAccountService $socialAccountService){}


    public function handleRedirect($provider){
        if(!$this->verifyProvider($provider)){
            return response([
                'error' => 'Wrong provider',
            ],Response::HTTP_UNAUTHORIZED);
        };
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleCallback($provider){
        if(!$this->verifyProvider($provider)){
            return response([
                'error' => 'Wrong provider',
            ],Response::HTTP_UNAUTHORIZED);
        };

        $socialUser = Socialite::driver($provider)->stateless()->user();

        return $this->socialAccountService->handleLogin($provider, $socialUser);
    }

    public function verifyProvider($provider): bool
    {
        return in_array($provider, ['facebook','google']);
    }
}
