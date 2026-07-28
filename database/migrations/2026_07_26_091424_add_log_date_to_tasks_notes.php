<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogDateToTasksNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->date('log_date')->nullable()->after('key_status');
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->date('log_date')->nullable()->after('key_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('log_date');
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('log_date');
        });
    }
}
