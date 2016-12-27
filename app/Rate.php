<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Rate
 *
 * @property int $id
 * @property int $user_id
 * @property string $rateable_type
 * @property string $rateable_id
 * @property int $star
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Course|\App\Teacher $rateable
 * @method static \Illuminate\Database\Query\Builder|\App\Rate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rate whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rate whereRateableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rate whereRateableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rate whereStar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rate whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rate whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rate extends Model
{
    protected $fillable = [
        'user_id',
        'rateable_type',
        'rateable_id',
        'star',
        'comment',
    ];

    public function rateable()
    {
        return $this->morphTo();
    }
}
