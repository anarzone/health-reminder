<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreReminderRequest;
use App\Models\Reminder;
use App\Models\TimeSchedule;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function updateStatus($reminderId, Request $request){
        Validator::make(['id'=>$reminderId,'status' => $request->input('status')], [
            'id' => 'required|exists:reminders,id,deleted_at,NULL',
            'status' => Rule::in([Reminder::STATUS_ACTIVE, Reminder::STATUS_DONE, Reminder::STATUS_MISSED])
        ])->validate(); // code smells

        return Response::success($this->reminderService->updateStatus($reminderId, $request->input('status')));
    }

    public function updateTimeScheduleStatus($reminderId, $timeScheduleId, Request $request){
        Validator::make(
            [
                'id' => $reminderId,
                'status' => $request->input('status'),
                'timeScheduleId' => $timeScheduleId,
            ],
            [
                'id' => 'required|exists:reminders,id,deleted_at,NULL',
                'timeScheduleId' => 'required|exists:time_schedules,id,deleted_at,NULL',
                'status' => Rule::in([TimeSchedule::STATUS_ACTIVE, TimeSchedule::STATUS_DONE, TimeSchedule::STATUS_MISSED])
            ]
        )->validate(); // code smells

        return Response::success(
            $this->reminderService->updateTimeScheduleStatus($timeScheduleId, $request->input('status'))
        );
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
