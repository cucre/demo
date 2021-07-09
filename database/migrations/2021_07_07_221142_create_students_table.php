<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->text('path_image')->nullable();
            $table->integer('type');
            $table->string('name');
            $table->string('paterno');
            $table->string('materno')->nullable();
            $table->string('cuip')->unique();
            $table->date('birth_date');
            $table->string('curp')->unique();
            $table->integer('cup')->nullable();
            $table->text('address')->nullable();
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('emergency_contact');
            $table->string('telephone_emergency_contact');
            $table->string('last_degree')->nullable();
            $table->string('workplace')->nullable();
            $table->string('job')->nullable();
            $table->text('observations')->nullable();
            $table->string('blood_type')->nullable();
            $table->text('medical_note')->nullable();
            $table->integer('type_leave')->nullable();
            $table->date('date_leave')->nullable();
            $table->string('reason_leave')->nullable();
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
        Schema::dropIfExists('students');
    }
}