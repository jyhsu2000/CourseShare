<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'year',
        'semester',
        'name',
        'description',
    ];

    public function courseTimes()
    {
        return $this->hasMany(CourseTime::class);
    }
}
