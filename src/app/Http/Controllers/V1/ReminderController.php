<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreReminderRequest;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReminderController extends Controller
{
    public function __construct(private ReminderService $reminderService)
    {
    }

    public function index(Request $request){
        return Response::success($this->reminderService->getAll($request->all()));
    }

    public function store(StoreReminderRequest $request){
        $result = $this->reminderService->store($request->all());

        return Response::success($result);
    }

    public function update(StoreReminderRequest $request){

    }

    public function delete($reminderId){

    }
}
