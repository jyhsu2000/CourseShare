<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Teacher
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $courses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rate[] $rates
 * @method static \Illuminate\Database\Query\Builder|\App\Teacher whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Teacher whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Teacher whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Teacher extends Model
{
    protected $fillable = [
        'name',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function rates()
    {
        return $this->morphMany(Rate::class, 'rateable');
    }

    public function getStarAttribute()
    {
        return ($this->rates()->avg('star') ?: 0) . ' / 5.0';
    }
}
