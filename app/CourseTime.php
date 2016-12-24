<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CourseTime
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseTable[] $courseTable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Period[] $periods
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTime whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTime whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTime whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTime whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTime whereUserId($value)
 */
class CourseTime extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courseTable()
    {
        return $this->belongsToMany(CourseTable::class);
    }

    public function periods()
    {
        return $this->belongsToMany(Period::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }
}
