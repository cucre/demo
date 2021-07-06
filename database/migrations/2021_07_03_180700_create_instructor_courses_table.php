<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorCoursesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('instructor_courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('instructor_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->integer('created_by')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('instructor_courses');
    }
}