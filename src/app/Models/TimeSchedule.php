<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSchedule extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_DONE = 2;
    const STATUS_MISSED = 3;

}
