<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Period
 *
 * @property int $id
 * @property int $weekday
 * @property int $number
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $courses
 * @property-read mixed $start_at
 * @property-read mixed $end_at
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereWeekday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Period whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Period extends Model
{
    protected static $duration_seconds = 50 * 60;
    protected $fillable = [
        'weekday',
        'number',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot('location');
    }

    public function getStartAtAttribute()
    {
        return static::getStartAt($this->number);
    }

    public static function getStartAt($number)
    {
        $carbon = new Carbon('8:10');
        $carbon->addHours($number - 1);

        return $carbon;
    }

    public function getEndAtAttribute()
    {
        return static::getEndAt($this->number);
    }

    public static function getEndAt($number)
    {
        $carbon = static::getStartAt($number);
        $carbon->addSeconds(static::$duration_seconds);

        return $carbon;
    }

    public static function getTimeRangeString($number)
    {
        $startAt = static::getStartAt($number);
        $endAt = static::getEndAt($number);

        return $startAt->format('H:i') . ' ~ ' . $endAt->format('H:i');
    }
}
