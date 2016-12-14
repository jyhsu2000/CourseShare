<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTime extends Model
{
    protected $fillable = [
        'course_id',
        'teacher_id',
        'location',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function courseTable()
    {
        return $this->belongsToMany(CourseTable::class);
    }

    public function periods()
    {
        return $this->belongsToMany(Period::class);
    }
}
