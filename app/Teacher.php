<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
    ];

    public function courseTimes()
    {
        return $this->hasMany(CourseTime::class);
    }
}
