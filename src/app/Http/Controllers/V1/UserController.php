<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(private UserService $userService){}

    public function store(StoreUserRequest $request){
        $request->merge(['password' => Hash::make($request->password)]);

        return Response::success($this->userService->store($request->all()));
    }
}
