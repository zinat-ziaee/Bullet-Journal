<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Database\Seeders\CollectionsTableSeeder;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('collections', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')
        ->constrained('users')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->string('name');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    Schema::dropIfExists('collections');
    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
  }
}
