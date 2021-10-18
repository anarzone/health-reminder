<?php

namespace App\Http\Resources;

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
            'start_date' => $this->dateSchedule->start_date,
            'end_date' => $this->dateSchedule->end_date,
            'every_selected_day' => $this->dateSchedule->every_selected_day,
            'time_schedules' => TimeScheduleResource::collection($this->timeSchedules),
        ];
    }
}
