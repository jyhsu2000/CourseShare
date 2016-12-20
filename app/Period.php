<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Period
 *
 * @property int $id
 * @property int $weekday
 * @property int $number
 * @property int $duration_second
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CourseTime[] $courseTime
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereWeekday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Period extends Model
{
    protected $fillable = [
        'weekday',
        'number',
    ];

    public function courseTime()
    {
        return $this->belongsToMany(CourseTime::class);
    }
}
