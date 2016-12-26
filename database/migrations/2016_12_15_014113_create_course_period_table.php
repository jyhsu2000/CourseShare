<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_period', function (Blueprint $table) {
            $table->string('course_id');
            $table->unsignedInteger('period_id');
            $table->string('location');
            $table->timestamps();

            $table->primary(['course_id', 'period_id']);
            $table->foreign('course_id')->references('id')->on('courses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('period_id')->references('id')->on('periods')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_period');
    }
}
