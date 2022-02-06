<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Response;

class SocialAccountService
{
    public function __construct(public SocialAccount $socialAccountModel, public User $userModel){}

    public function handleLogin($provider, $data){
        $user = $this->userModel->updateOrCreate(['email' => $data['email']],[
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['email'])
        ]);

        $user->socialAccounts()->updateOrCreate(['provider_user_id' => $data['id']],[
            'provider' => $provider,
            'provider_user_id' => $data['id']
        ]);

        return Response::success([
            'access_token' => $user->createToken('API Token')->plainTextToken,
            'type' => 'Bearer',
        ]);
    }
}
