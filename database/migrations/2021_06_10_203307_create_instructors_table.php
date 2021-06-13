<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->string('cuip')->unique();
            $table->string('curp')->unique();
            $table->date('birth_date');
            $table->text('address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->unique();
            $table->string('specialty')->nullable();
            $table->text('certifications')->nullable();
            $table->text('observations')->nullable();
            $table->string('blood_type')->nullable();
            $table->text('medical_note')->nullable();
            $table->integer('document_id')->unsigned()->nullable();
            $table->foreign('document_id')->references('id')->on('documents');
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
        Schema::dropIfExists('instructors');
    }
}