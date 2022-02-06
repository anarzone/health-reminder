<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAccountService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function __construct(public SocialAccountService $socialAccountService)
    {
    }

    /**
     * @deprecated
     */
    public function handleRedirect($provider)
    {
        if (!$this->verifyProvider($provider)) {
            return response([
                'error' => 'Wrong provider',
            ], Response::HTTP_UNAUTHORIZED);
        };
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * @deprecated
     */
    public function handleCallback($provider)
    {
        if (!$this->verifyProvider($provider)) {
            return response([
                'error' => 'Wrong provider',
            ], Response::HTTP_UNAUTHORIZED);
        };

        $socialUser = Socialite::driver($provider)->stateless()->user();

        return $this->socialAccountService->handleLogin($provider, $socialUser);
    }

    public function handleProviders($provider, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'id' => 'required|numeric',
        ]);

        if (!$this->verifyProvider($provider)) {
            return response([
                'error' => 'Wrong provider',
            ], Response::HTTP_UNAUTHORIZED);
        };

        return $this->socialAccountService->handleLogin($provider, $request->all());
    }

    private function verifyProvider($provider): bool
    {
        return in_array($provider, ['facebook', 'google']);
    }
}
