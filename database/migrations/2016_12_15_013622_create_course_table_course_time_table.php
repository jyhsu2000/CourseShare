<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTableCourseTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_table_course_time', function (Blueprint $table) {
            $table->unsignedInteger('course_table_id');
            $table->unsignedInteger('course_time_id');
            $table->timestamps();

            $table->primary(['course_table_id', 'course_time_id']);
            $table->foreign('course_table_id')->references('id')->on('course_tables')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_time_id')->references('id')->on('course_times')
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
        Schema::dropIfExists('course_table_course_time');
    }
}
