<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
