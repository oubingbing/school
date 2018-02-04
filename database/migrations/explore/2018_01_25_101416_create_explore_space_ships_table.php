<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExploreSpaceShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('explore_space_ships', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->index()->comment('飞船的名字');
            $table->bigInteger('planet_id')->index()->comment('所属行星');
            $table->jsonb('surface')->comment('飞船的外表');
            $table->string('task')->nullable()->comment('飞船的任务');

            $table->tinyInteger('status')->default(0)->comment('飞船的状态');
            $table->tinyInteger('type')->default(0)->comment('飞船的类型');

            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('explore_space_ships', function (Blueprint $table) {
            //
        });
    }
}
