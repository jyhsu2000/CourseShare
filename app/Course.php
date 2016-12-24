<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Course
 *
 * @property int $id
 * @property int $user_id
 * @property int $year
 * @property int $semester
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseTime[] $courseTimes
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSemester($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    protected $fillable = [
        'user_id',
        'year',
        'semester',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseTimes()
    {
        return $this->hasMany(CourseTime::class);
    }

    public static function getYearRange()
    {
        $startYear = 90;
        $endYear = Carbon::now()->year - 1911;
        $range = range($startYear, $endYear);
        $array = array_combine($range, $range);

        return $array;
    }
}
