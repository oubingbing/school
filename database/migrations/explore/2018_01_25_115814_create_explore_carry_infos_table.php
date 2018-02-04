<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExploreCarryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('explore_carry_infos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('space_ship_id')->index()->comment('飞船的Id');
            $table->bigInteger('planet_id')->index()->comment('行星的Id');
            $table->longText('message')->nullable()->comment('携带的文本信息');
            $table->jsonb('attachments')->nullable()->comment('携带其他信息');

            $table->tinyInteger('status')->default(1)->comment('');
            $table->tinyInteger('type')->defalut(1)->comment('携带的信息来源类型,1=母星,2=其他星球');

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
        Schema::table('explore_carry_infos', function (Blueprint $table) {
            //
        });
    }
}
