<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Response;

class SocialAccountService
{
    public function __construct(public SocialAccount $socialAccountModel, public User $userModel){}

    public function handleLogin($provider, $socialAccount){
        $user = $this->userModel->updateOrCreate(['email' => $socialAccount->getEmail()],[
            'name' => $socialAccount->getName(),
            'email' => $socialAccount->getEmail(),
            'password' => bcrypt($socialAccount->getEmail())
        ]);

        $user->socialAccounts()->updateOrCreate(['provider_user_id' => $socialAccount->getId()],[
            'provider' => $provider,
            'provider_user_id' => $socialAccount->getId()
        ]);

        return Response::success([
            'access_token' => $user->createToken('API Token')->plainTextToken,
            'type' => 'Bearer',
        ]);
    }
}
