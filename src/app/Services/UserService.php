<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function __construct(private User $userModel){}

    public function getDetails(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function store($data): UserResource
    {
        $user = $this->userModel->updateOrCreate(['id' => auth()->user()->id ?? null], $data);

        return new UserResource($user);
    }
}
