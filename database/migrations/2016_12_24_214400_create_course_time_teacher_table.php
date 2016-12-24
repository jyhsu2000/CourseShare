<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTimeTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_time_teacher', function (Blueprint $table) {
            $table->unsignedInteger('course_time_id');
            $table->unsignedInteger('teacher_id');
            $table->timestamps();

            $table->primary(['course_time_id', 'teacher_id']);
            $table->foreign('course_time_id')->references('id')->on('course_times')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
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
        Schema::dropIfExists('course_time_teacher');
    }
}
