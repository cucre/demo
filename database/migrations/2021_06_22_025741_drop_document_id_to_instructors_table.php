<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDocumentIdToInstructorsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropColumn('document_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('instructors', function (Blueprint $table) {
            $table->integer('document_id')->unsigned()->nullable();
            $table->foreign('document_id')->references('id')->on('documents');
        });
    }
}