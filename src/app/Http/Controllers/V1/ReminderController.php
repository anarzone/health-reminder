<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreReminderRequest;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ReminderController extends Controller
{
    public function __construct(private ReminderService $reminderService)
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request){
        return Response::success($this->reminderService->getAll($request->all()));
    }

    public function edit($reminderId){

        return Response::success($this->reminderService->single($reminderId));
    }

    public function store(StoreReminderRequest $request){
        $result = $this->reminderService->store($request->all());

        return Response::success($result);
    }

    public function update($reminderId, StoreReminderRequest $request){
        Validator::make(['id'=>$reminderId], ['id' => 'required|exists:reminders,id,deleted_at,NULL'])->validate(); // code smells
        return Response::success($this->reminderService->store($request->merge(['id' => $reminderId])->all()));
    }

    public function delete($reminderId){
        Validator::make(['id'=>$reminderId], ['id' => 'required|exists:reminders,id,deleted_at,NULL'])->validate();

        $this->reminderService->delete($reminderId);
        return new Response([],Response::HTTP_NO_CONTENT);
    }

    public function getColors(){
        return Response::success($this->reminderService->colors());
    }

    public function getShapes(){
        return Response::success($this->reminderService->shapes());
    }
}
