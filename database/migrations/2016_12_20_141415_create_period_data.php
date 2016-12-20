<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (range(0, 6) as $weekday) {
            foreach (range(1, 14) as $periodNumber) {
                \App\Period::create([
                    'weekday' => $weekday,
                    'number'  => $periodNumber,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Period::query()->delete();
    }
}
