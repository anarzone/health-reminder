<?php

namespace App\Services;

use App\Http\Resources\ColorResource;
use App\Http\Resources\ReminderResource;
use App\Http\Resources\ShapeResource;
use App\Models\Color;
use App\Models\Reminder;
use App\Models\Shape;
use App\Models\TimeSchedule;
use Illuminate\Support\Carbon;

class ReminderService
{
    public function __construct(
        private Reminder $reminderModel,
        private TimeSchedule $timeScheduleModel
    ){}

    /**
     * @param $filters
     * @return ReminderResource
     */
    public function getAll($filters){
        $query = $this->reminderModel->newQuery();
        $query = $query->where('user_id',auth()->user()->id);

        if(isset($filters)){
            $query = $query->join('date_schedules as d', 'reminders.id','=','d.reminder_id');
            $query = $query->join('shapes as sh', 'sh.id','=','reminders.shape_id');

            if(isset($filters['from'])){
                $query = $query->whereDate('d.start_date','>=', Carbon::make($filters['from'])->toDate());
            }
            if (isset($filters['to'])){
                $query = $query->whereDate('d.end_date','<=', Carbon::make($filters['to'])->toDate());
            }
            if(isset($filters['shape'])){
                $query = $query->where('sh.id','=',intval($filters['shape']));
            }
        }

        return ReminderResource::collection($query->get());
    }

    public function single($id){
        return new ReminderResource($this->reminderModel->where('id',$id)->first());
    }

    public function store($data){
        $reminder = $this->reminderModel->updateOrCreate(['id' => $data['id'] ?? null], [
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => auth()->user()->id,
            'shape_id' => $data['shape_id'],
            'color_id' => $data['color_id'],
        ]);

        if(isset($data['start_date']) && isset($data['end_date'])){
            $reminder->dateSchedule()->create([
                'start_date' => Carbon::make($data['start_date'])->toDate(),
                'end_date' => Carbon::make($data['end_date'])->toDate(),
                'every_selected_day' => $data['every_selected_day'],
            ]);
        }

        $timeSchedules = array_map(function ($schedule) use($reminder){
            return array_merge($schedule,['reminder_id' => $reminder->id]);
        }, $data['time_schedules']);

        $reminder->timeSchedules()->delete();
        $reminder->timeSchedules()->insert($timeSchedules);

        return new ReminderResource($reminder);
    }

    public function updateStatus($id, $status){
        return $this->reminderModel->find($id)->update(['status' => $status]);
    }

    public function updateTimeScheduleStatus($timeScheduleId, $status){
        return $this->timeScheduleModel->find($timeScheduleId)->update(['status' => $status]);
    }

    public function delete($id){
        $this->reminderModel->findOrFail($id)->delete();
    }

    public function colors(){
        return ColorResource::collection(Color::all());
    }

    public function shapes(){
        return ShapeResource::collection(Shape::all());
    }
}
