<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CourseTable
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $courses
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTable whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTable whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTable whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTable whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTable whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseTable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CourseTable extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'order',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
