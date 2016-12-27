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

    public function getRates()
    {
        $rates = Rate::with('user')
            ->where('rateable_type', $this->getRateableType())
            ->where('rateable_id', $this->getRateableId())
            ->orderBy('updated_at', 'desc')
            ->get();

        return $rates;
    }

    public function getAverageRate()
    {
        $averageRate = Rate::where('rateable_type', $this->getRateableType())
            ->where('rateable_id', $this->getRateableId())
            ->avg('star');

        return $averageRate;
    }

    public function getStarSelectOptions()
    {
        $options = [];
        for ($i = 1; $i <= 5; $i++) {
            $options[$i] = str_repeat('★', $i) . str_repeat('☆', 5 - $i);
        }

        return $options;
    }

    public function getStarIcon($star)
    {
        $icon = str_repeat('<i class="fa fa-star fa-2x" aria-hidden="true"></i>', $star)
            . str_repeat('<i class="fa fa-star-o fa-2x" aria-hidden="true"></i>', 5 - $star);

        return $icon;
    }
}
