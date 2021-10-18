<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function __construct(private User $userModel)
    {
    }

    public function store($data){
        $user = $this->userModel->create($data);

        return new UserResource($user);
    }
}
