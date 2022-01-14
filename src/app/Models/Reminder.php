<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_DONE = 2;
    const STATUS_MISSED = 3;

    protected $fillable = ['title','description','status','user_id','shape_id','color_id'];

    public function dateSchedule(){
        return $this->hasOne(DateSchedule::class, 'reminder_id');
    }

    public function timeSchedules(){
        return $this->hasMany(TimeSchedule::class, 'reminder_id');
    }

    public function shape(){
        return $this->belongsTo(Shape::class, 'shape_id');
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
