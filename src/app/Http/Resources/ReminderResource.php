<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'start_date' => Carbon::make($this->dateSchedule->start_date)->toDateString(),
            'end_date' => Carbon::make($this->dateSchedule->end_date)->toDateString(),
            'every_selected_day' => $this->dateSchedule->every_selected_day,
            'time_schedules' => TimeScheduleResource::collection($this->timeSchedules),
            'shape' => $this->shape->name
        ];
    }
}
