<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToInstructorsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('instructors', function (Blueprint $table) {
            $table->integer('type_leave')->nullable();
            $table->date('date_leave')->nullable();
            $table->string('reason_leave')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropColumn('type_leave');
            $table->dropColumn('date_leave');
            $table->dropColumn('reason_leave');
        });
    }
}