<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'weekday',
        'start_at',
        'duration_second',
    ];

    public function courseTime()
    {
        return $this->belongsToMany(CourseTime::class);
    }
}
