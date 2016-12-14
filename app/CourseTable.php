<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTable extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseTimes()
    {
        return $this->belongsToMany(CourseTime::class);
    }
}
