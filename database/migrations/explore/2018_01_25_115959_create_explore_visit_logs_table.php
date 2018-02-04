<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExploreVisitLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('explore_visit_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('space_ship_id')->index()->comment('飞船Id');
            $table->bigInteger('planet_id')->index()->comment('行星Id');

            $table->float('mileage')->default(0)->comment('抵达该行星航行了多少里程');
            $table->timestamp('arrived_at')->nullable()->comment('抵达行星的时间');
            $table->timestamp('leaved_at')->nullable()->comment('离开行星的时间');

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
        Schema::table('explore_visit_logs', function (Blueprint $table) {
            //
        });
    }
}
