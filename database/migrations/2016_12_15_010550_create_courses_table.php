<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('id')->primary()->comment('課程編號');
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('year')->comment('學年');
            $table->integer('semester')->comment('學期');
            $table->string('scr_period')->comment('上課時間/上課教室/授課教師');
            $table->integer('scr_acptcnt')->default(0)->comment('實收名額');
            $table->string('sub_name')->comment('科目名稱');
            $table->string('scj_scr_mso')->comment('必選修');
            $table->integer('scr_precnt')->default(0)->comment('開放名額');
            $table->string('scr_selcode')->comment('選課代號');
            $table->integer('scr_credit')->default(0)->comment('學分');
            $table->integer('unt_ls')->default(0);
            $table->string('scr_dup');
            $table->string('scr_remarks')->comment('備註');
            $table->string('cls_name')->comment('班級');
            $table->string('sub_id')->comment('課程ID');
            $table->string('cls_id')->comment('班級ID');
            $table->string('scr_exambf')->comment('提前考');
            $table->string('scr_examid')->comment('期中考');
            $table->string('scr_examfn')->comment('期末考');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
