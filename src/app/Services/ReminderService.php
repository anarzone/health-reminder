<?php

namespace App\Services;

use App\Http\Resources\ColorResource;
use App\Http\Resources\ReminderResource;
use App\Http\Resources\ShapeResource;
use App\Models\Color;
use App\Models\Reminder;
use App\Models\Shape;
use Illuminate\Support\Carbon;

class ReminderService
{
    public function __construct(
        private Reminder $reminderModel
    ){}

    /**
     * @param $filters
     * @return ReminderResource
     */
    public function getAll($filters){
        $query = $this->reminderModel->newQuery();

        if(isset($filters)){
            $query = $query->join('date_schedules as d', 'reminders.id','=','d.reminder_id');

            if(isset($filters['from'])){
                $query = $query->whereDate('d.start_date','>=', Carbon::make($filters['from'])->toDate());
            }
            if (isset($filters['to'])){
                $query = $query->whereDate('d.end_date','<=', Carbon::make($filters['to'])->toDate());
            }
        }

        return ReminderResource::collection($query->get());
    }

    public function single($id){
        return new ReminderResource($this->reminderModel->where('id',$id)->first());
    }

    public function store($data){
        $reminder = $this->reminderModel->updateOrCreate(['id' => intval($data['id']) ?? null], [
            'title' => $data['title'],
            'description' => $data['description'],
            'shape_id' => $data['shape_id'],
            'color_id' => $data['color_id'],
        ]);

        if(isset($data['start_date']) && isset($data['end_date'])){
            $reminder->dateSchedule()->create([
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
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
