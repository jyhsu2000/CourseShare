<?php

namespace App\Presenters;

use App\Rate;

class RatePresenter
{
    public function getRateableType()
    {
        $rateable_type = get_class(collect(request()->route()->parameters())->first());

        return $rateable_type;
    }

    public function getRateableId()
    {
        $rateable_id = collect(request()->route()->parameters())->first()->id;

        return $rateable_id;
    }

    public function getUserRate()
    {
        $user = auth()->user();
        $rate = Rate::where('user_id', $user->id)
            ->where('rateable_type', $this->getRateableType())
            ->where('rateable_id', $this->getRateableId())
            ->first();

        return $rate;
    }
}
