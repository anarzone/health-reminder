<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Shape extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    protected $fillable = ['name'];

    public $translatable = ['name'];
}
